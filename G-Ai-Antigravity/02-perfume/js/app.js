/**
 * K-gi Perfume CRUD System - Application Controller
 * Handles UI events, validations, rendering, filters, and page routing logic.
 */

// Toast notification helper
function showToast(message, type = 'success') {
  let toastContainer = document.querySelector('.toast-container');
  if (!toastContainer) {
    toastContainer = document.createElement('div');
    toastContainer.className = 'toast-container';
    document.body.appendChild(toastContainer);
  }

  const icons = {
    success: 'bi-check-circle-fill text-success',
    danger: 'bi-exclamation-octagon-fill text-danger',
    warning: 'bi-exclamation-triangle-fill text-warning',
    info: 'bi-info-circle-fill text-info'
  };

  const toastId = 'toast-' + Date.now();
  const html = `
    <div id="${toastId}" class="toast toast-luxury align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body d-flex align-items-center gap-2">
          <i class="bi ${icons[type] || icons.info} fs-5"></i>
          <div>${message}</div>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  `;

  toastContainer.insertAdjacentHTML('beforeend', html);
  const elem = document.getElementById(toastId);
  const bsToast = new bootstrap.Toast(elem, { delay: 3500 });
  bsToast.show();

  elem.addEventListener('hidden.bs.toast', () => {
    elem.remove();
  });
}

// Currency formatter helper
function formatCurrency(amount) {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD'
  }).format(amount || 0);
}

// Helper: Setup active nav state
function highlightActiveNavLink() {
  const currentPath = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPath || (currentPath === '' && href === 'index.html')) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });
}

// Global Delete Modal handler
let itemToDeleteId = null;
function openDeleteModal(productId, productName) {
  itemToDeleteId = productId;
  const nameEl = document.getElementById('deleteProductName');
  if (nameEl) nameEl.textContent = productName || productId;

  const modalEl = document.getElementById('deleteConfirmModal');
  if (modalEl) {
    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
  }
}

// Common setup for Delete Modal
function setupDeleteModal(onDeleteSuccess) {
  const confirmBtn = document.getElementById('confirmDeleteBtn');
  if (confirmBtn) {
    confirmBtn.onclick = () => {
      if (!itemToDeleteId) return;
      const success = PerfumeStore.delete(itemToDeleteId);
      const modalEl = document.getElementById('deleteConfirmModal');
      if (modalEl) {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
      }

      if (success) {
        showToast(`Fragrance <strong>${itemToDeleteId}</strong> was removed.`, 'danger');
        if (typeof onDeleteSuccess === 'function') {
          onDeleteSuccess(itemToDeleteId);
        }
      }
      itemToDeleteId = null;
    };
  }
}

// ===================================================================
// 1. DASHBOARD PAGE CONTROLLER
// ===================================================================
function initDashboardPage() {
  const stats = PerfumeStore.getStats();

  // Populate KPIs
  const totalProductsEl = document.getElementById('statTotalProducts');
  const totalUnitsEl = document.getElementById('statTotalUnits');
  const inventoryValueEl = document.getElementById('statInventoryValue');
  const lowStockEl = document.getElementById('statLowStock');

  if (totalProductsEl) totalProductsEl.textContent = stats.totalItems;
  if (totalUnitsEl) totalUnitsEl.textContent = stats.totalInventoryCount.toLocaleString();
  if (inventoryValueEl) inventoryValueEl.textContent = formatCurrency(stats.totalInventoryValue);
  if (lowStockEl) lowStockEl.textContent = (stats.lowStockCount + stats.outOfStockCount);

  // Category breakdown list
  const catListEl = document.getElementById('categoryBreakdownList');
  if (catListEl) {
    const cats = Object.entries(stats.categoriesMap);
    if (cats.length === 0) {
      catListEl.innerHTML = '<li class="text-muted">No categories recorded.</li>';
    } else {
      catListEl.innerHTML = cats.map(([cat, count]) => {
        const percent = stats.totalItems > 0 ? Math.round((count / stats.totalItems) * 100) : 0;
        return `
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1 small">
              <span class="text-light">${cat}</span>
              <span class="text-gold fw-bold">${count} items (${percent}%)</span>
            </div>
            <div class="progress" style="height: 6px; background-color: rgba(255,255,255,0.08);">
              <div class="progress-bar bg-warning" role="progressbar" style="width: ${percent}%; background-color: var(--primary-gold) !important;" aria-valuenow="${percent}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        `;
      }).join('');
    }
  }

  // Populate Recent Fragrances Table
  const recentTableBody = document.getElementById('recentProductsTableBody');
  if (recentTableBody) {
    if (stats.recentProducts.length === 0) {
      recentTableBody.innerHTML = `
        <tr>
          <td colspan="6" class="text-center py-4 text-muted">
            <i class="bi bi-inbox fs-3 d-block mb-2"></i> No fragrances found in catalog.
          </td>
        </tr>`;
    } else {
      recentTableBody.innerHTML = stats.recentProducts.map(p => {
        const status = PerfumeStore.getStockStatus(p.stock, p.minStockThreshold);
        return `
          <tr>
            <td>
              <div class="d-flex align-items-center gap-3">
                <img src="${p.image}" alt="${p.name}" class="product-thumbnail" onerror="this.src='https://images.unsplash.com/photo-1547887537-6158d64c35b3?auto=format&fit=crop&w=150&q=80'">
                <div>
                  <a href="view-product.html?id=${encodeURIComponent(p.id)}" class="fw-semibold text-white text-decoration-none d-block">
                    ${p.name}
                  </a>
                  <small class="text-muted">${p.brand} &bull; ${p.concentration}</small>
                </div>
              </div>
            </td>
            <td><span class="badge bg-dark border border-secondary text-secondary">${p.id}</span></td>
            <td><span class="text-muted small">${p.category}</span></td>
            <td class="fw-bold text-gold">${formatCurrency(p.price)}</td>
            <td>
              <span class="badge-status ${status.badgeClass}">
                <span class="status-dot"></span> ${status.label} (${p.stock})
              </span>
            </td>
            <td class="text-end">
              <div class="d-inline-flex gap-1">
                <a href="view-product.html?id=${encodeURIComponent(p.id)}" class="action-btn btn-view" title="View Details">
                  <i class="bi bi-eye"></i>
                </a>
                <a href="edit-product.html?id=${encodeURIComponent(p.id)}" class="action-btn btn-edit" title="Edit Fragrance">
                  <i class="bi bi-pencil"></i>
                </a>
                <button type="button" class="action-btn btn-delete" title="Delete" onclick="openDeleteModal('${p.id}', '${p.name.replace(/'/g, "\\'")}')">
                  <i class="bi bi-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        `;
      }).join('');
    }
  }

  setupDeleteModal(() => {
    initDashboardPage();
  });
}

// ===================================================================
// 2. PRODUCTS LIST PAGE CONTROLLER
// ===================================================================
function initProductsPage() {
  const searchInput = document.getElementById('searchProductInput');
  const categoryFilter = document.getElementById('filterCategory');
  const stockFilter = document.getElementById('filterStock');
  const sortFilter = document.getElementById('filterSort');
  const resetFilterBtn = document.getElementById('resetFiltersBtn');
  const productsTableBody = document.getElementById('productsTableBody');
  const productCountBadge = document.getElementById('productCountBadge');
  const emptyStateWrapper = document.getElementById('emptyStateWrapper');
  const resetCatalogBtn = document.getElementById('btnResetCatalog');
  const exportCsvBtn = document.getElementById('btnExportCsv');
  const exportJsonBtn = document.getElementById('btnExportJson');

  let currentPage = 1;
  const itemsPerPage = 7;

  // Render Category Filter Dropdown Options dynamically
  function populateCategoriesDropdown() {
    if (!categoryFilter) return;
    const products = PerfumeStore.getAll();
    const categories = Array.from(new Set(products.map(p => p.category).filter(Boolean))).sort();
    
    // Preserve current selection
    const currentVal = categoryFilter.value;
    categoryFilter.innerHTML = '<option value="">All Fragrance Categories</option>';
    categories.forEach(cat => {
      categoryFilter.innerHTML += `<option value="${cat}">${cat}</option>`;
    });
    categoryFilter.value = currentVal;
  }

  function renderTable() {
    const allProducts = PerfumeStore.getAll();
    const query = (searchInput ? searchInput.value : '').trim().toLowerCase();
    const selectedCategory = categoryFilter ? categoryFilter.value : '';
    const selectedStock = stockFilter ? stockFilter.value : '';
    const selectedSort = sortFilter ? sortFilter.value : 'newest';

    // 1. Filtering
    let filtered = allProducts.filter(item => {
      // Search matches name, brand, SKU or notes
      const matchSearch = !query || (
        (item.name && item.name.toLowerCase().includes(query)) ||
        (item.brand && item.brand.toLowerCase().includes(query)) ||
        (item.id && item.id.toLowerCase().includes(query)) ||
        (item.topNotes && item.topNotes.toLowerCase().includes(query)) ||
        (item.category && item.category.toLowerCase().includes(query))
      );

      // Category match
      const matchCategory = !selectedCategory || item.category === selectedCategory;

      // Stock filter match
      let matchStock = true;
      if (selectedStock === 'in_stock') {
        matchStock = item.stock > (item.minStockThreshold || 10);
      } else if (selectedStock === 'low_stock') {
        matchStock = item.stock > 0 && item.stock <= (item.minStockThreshold || 10);
      } else if (selectedStock === 'out_of_stock') {
        matchStock = item.stock <= 0;
      }

      return matchSearch && matchCategory && matchStock;
    });

    // 2. Sorting
    filtered.sort((a, b) => {
      switch (selectedSort) {
        case 'name_asc':
          return a.name.localeCompare(b.name);
        case 'name_desc':
          return b.name.localeCompare(a.name);
        case 'price_asc':
          return (a.price || 0) - (b.price || 0);
        case 'price_desc':
          return (b.price || 0) - (a.price || 0);
        case 'stock_asc':
          return (a.stock || 0) - (b.stock || 0);
        case 'stock_desc':
          return (b.stock || 0) - (a.stock || 0);
        case 'newest':
        default:
          return new Date(b.createdAt || 0) - new Date(a.createdAt || 0);
      }
    });

    // Count badge
    if (productCountBadge) {
      productCountBadge.textContent = `${filtered.length} of ${allProducts.length} items`;
    }

    // Check empty state
    if (filtered.length === 0) {
      if (productsTableBody) productsTableBody.innerHTML = '';
      if (emptyStateWrapper) emptyStateWrapper.classList.remove('d-none');
      renderPagination(0);
      return;
    } else {
      if (emptyStateWrapper) emptyStateWrapper.classList.add('d-none');
    }

    // 3. Pagination
    const totalPages = Math.ceil(filtered.length / itemsPerPage);
    if (currentPage > totalPages) currentPage = totalPages || 1;

    const startIndex = (currentPage - 1) * itemsPerPage;
    const paginatedItems = filtered.slice(startIndex, startIndex + itemsPerPage);

    // 4. Render Rows
    if (productsTableBody) {
      productsTableBody.innerHTML = paginatedItems.map(p => {
        const status = PerfumeStore.getStockStatus(p.stock, p.minStockThreshold);
        return `
          <tr>
            <td>
              <div class="d-flex align-items-center gap-3">
                <img src="${p.image}" alt="${p.name}" class="product-thumbnail" onerror="this.src='https://images.unsplash.com/photo-1547887537-6158d64c35b3?auto=format&fit=crop&w=150&q=80'">
                <div>
                  <a href="view-product.html?id=${encodeURIComponent(p.id)}" class="fw-semibold text-white text-decoration-none d-block hover-gold">
                    ${p.name}
                  </a>
                  <span class="text-muted small">${p.brand} &bull; ${p.gender || 'Unisex'}</span>
                </div>
              </div>
            </td>
            <td><code class="text-gold bg-dark px-2 py-1 rounded border border-dark-subtle">${p.id}</code></td>
            <td>
              <span class="badge bg-dark border border-secondary text-light">${p.category}</span>
            </td>
            <td>
              <span class="text-white-50 small">${p.concentration} (${p.size})</span>
            </td>
            <td class="fw-bold text-gold">${formatCurrency(p.price)}</td>
            <td>
              <span class="badge-status ${status.badgeClass}">
                <span class="status-dot"></span> ${status.label}
              </span>
              <div class="small text-muted mt-1">${p.stock} units</div>
            </td>
            <td class="text-end">
              <div class="d-inline-flex gap-1">
                <a href="view-product.html?id=${encodeURIComponent(p.id)}" class="action-btn btn-view" title="View Details">
                  <i class="bi bi-eye"></i>
                </a>
                <a href="edit-product.html?id=${encodeURIComponent(p.id)}" class="action-btn btn-edit" title="Edit Fragrance">
                  <i class="bi bi-pencil"></i>
                </a>
                <button type="button" class="action-btn btn-delete" title="Delete Fragrance" onclick="openDeleteModal('${p.id}', '${p.name.replace(/'/g, "\\'")}')">
                  <i class="bi bi-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        `;
      }).join('');
    }

    renderPagination(totalPages);
  }

  function renderPagination(totalPages) {
    const paginationEl = document.getElementById('productsPagination');
    if (!paginationEl) return;

    if (totalPages <= 1) {
      paginationEl.innerHTML = '';
      return;
    }

    let html = `
      <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a class="page-link" href="#" data-page="${currentPage - 1}" aria-label="Previous">&laquo;</a>
      </li>
    `;

    for (let i = 1; i <= totalPages; i++) {
      html += `
        <li class="page-item ${currentPage === i ? 'active' : ''}">
          <a class="page-link" href="#" data-page="${i}">${i}</a>
        </li>
      `;
    }

    html += `
      <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a class="page-link" href="#" data-page="${currentPage + 1}" aria-label="Next">&raquo;</a>
      </li>
    `;

    paginationEl.innerHTML = html;

    paginationEl.querySelectorAll('a.page-link').forEach(link => {
      link.addEventListener('click', e => {
        e.preventDefault();
        const page = parseInt(link.getAttribute('data-page'), 10);
        if (page >= 1 && page <= totalPages && page !== currentPage) {
          currentPage = page;
          renderTable();
        }
      });
    });
  }

  // Event Listeners
  if (searchInput) searchInput.addEventListener('input', () => { currentPage = 1; renderTable(); });
  if (categoryFilter) categoryFilter.addEventListener('change', () => { currentPage = 1; renderTable(); });
  if (stockFilter) stockFilter.addEventListener('change', () => { currentPage = 1; renderTable(); });
  if (sortFilter) sortFilter.addEventListener('change', () => { currentPage = 1; renderTable(); });

  if (resetFilterBtn) {
    resetFilterBtn.addEventListener('click', () => {
      if (searchInput) searchInput.value = '';
      if (categoryFilter) categoryFilter.value = '';
      if (stockFilter) stockFilter.value = '';
      if (sortFilter) sortFilter.value = 'newest';
      currentPage = 1;
      renderTable();
    });
  }

  // Export buttons
  if (exportCsvBtn) {
    exportCsvBtn.addEventListener('click', () => {
      PerfumeStore.exportCSV();
      showToast('Exporting catalog as CSV...', 'info');
    });
  }

  if (exportJsonBtn) {
    exportJsonBtn.addEventListener('click', () => {
      PerfumeStore.exportJSON();
      showToast('Exporting catalog as JSON...', 'info');
    });
  }

  // Reset to default sample catalog
  if (resetCatalogBtn) {
    resetCatalogBtn.addEventListener('click', () => {
      if (confirm('Reset catalog to default luxury sample fragrances? Any custom additions will be restored to defaults.')) {
        PerfumeStore.resetToDefaults();
        populateCategoriesDropdown();
        renderTable();
        showToast('Inventory reset to initial luxury collection.', 'success');
      }
    });
  }

  setupDeleteModal(() => {
    populateCategoriesDropdown();
    renderTable();
  });

  populateCategoriesDropdown();
  renderTable();
}

// ===================================================================
// 3. ADD PRODUCT PAGE CONTROLLER
// ===================================================================
function initAddProductPage() {
  const form = document.getElementById('addProductForm');
  const skuInput = document.getElementById('productSku');
  const imageInput = document.getElementById('productImage');
  const imagePreview = document.getElementById('imagePreview');
  const placeholderWrapper = document.getElementById('imagePlaceholder');
  const samplePills = document.querySelectorAll('.sample-image-pill');

  // Auto generate ID
  if (skuInput && !skuInput.value) {
    skuInput.value = PerfumeStore.generateId();
  }

  // Live image preview listener
  function updateImagePreview(url) {
    if (!imagePreview) return;
    if (url && url.trim().length > 5) {
      imagePreview.src = url.trim();
      imagePreview.classList.remove('d-none');
      if (placeholderWrapper) placeholderWrapper.classList.add('d-none');
    } else {
      imagePreview.classList.add('d-none');
      if (placeholderWrapper) placeholderWrapper.classList.remove('d-none');
    }
  }

  if (imageInput) {
    imageInput.addEventListener('input', e => {
      updateImagePreview(e.target.value);
    });
  }

  // Preset sample image pickers
  samplePills.forEach(pill => {
    pill.addEventListener('click', () => {
      const url = pill.getAttribute('data-img');
      if (imageInput && url) {
        imageInput.value = url;
        updateImagePreview(url);
      }
    });
  });

  // Form submission
  if (form) {
    form.addEventListener('submit', event => {
      event.preventDefault();
      event.stopPropagation();

      if (!form.checkValidity()) {
        form.classList.add('was-validated');
        showToast('Please fill in all required fields accurately.', 'warning');
        return;
      }

      const newProduct = {
        id: (document.getElementById('productSku').value || '').trim(),
        name: (document.getElementById('productName').value || '').trim(),
        brand: (document.getElementById('productBrand').value || '').trim(),
        category: (document.getElementById('productCategory').value || '').trim(),
        gender: (document.getElementById('productGender').value || 'Unisex'),
        concentration: (document.getElementById('productConcentration').value || 'Eau de Parfum'),
        size: (document.getElementById('productSize').value || '100ml'),
        price: parseFloat(document.getElementById('productPrice').value) || 0,
        costPrice: parseFloat(document.getElementById('productCostPrice').value) || 0,
        stock: parseInt(document.getElementById('productStock').value, 10) || 0,
        minStockThreshold: parseInt(document.getElementById('productMinStock').value, 10) || 10,
        topNotes: (document.getElementById('productTopNotes').value || '').trim(),
        heartNotes: (document.getElementById('productHeartNotes').value || '').trim(),
        baseNotes: (document.getElementById('productBaseNotes').value || '').trim(),
        description: (document.getElementById('productDescription').value || '').trim(),
        image: (document.getElementById('productImage').value || '').trim()
      };

      try {
        const created = PerfumeStore.create(newProduct);
        showToast(`Fragrance <strong>${created.name}</strong> was created successfully!`, 'success');

        // Disable submit button to prevent double-post
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
          submitBtn.disabled = true;
          submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving Fragrance...';
        }

        setTimeout(() => {
          window.location.href = `view-product.html?id=${encodeURIComponent(created.id)}`;
        }, 800);
      } catch (err) {
        showToast(err.message, 'danger');
      }
    });
  }
}

// ===================================================================
// 4. EDIT PRODUCT PAGE CONTROLLER
// ===================================================================
function initEditProductPage() {
  const urlParams = new URLSearchParams(window.location.search);
  const productId = urlParams.get('id');

  if (!productId) {
    showToast('No fragrance ID specified to edit.', 'warning');
    setTimeout(() => { window.location.href = 'products.html'; }, 1000);
    return;
  }

  const product = PerfumeStore.getById(productId);
  if (!product) {
    showToast(`Fragrance "${productId}" was not found in catalog.`, 'danger');
    setTimeout(() => { window.location.href = 'products.html'; }, 1200);
    return;
  }

  // Pre-fill form fields
  document.getElementById('editProductSku').value = product.id;
  document.getElementById('editProductName').value = product.name || '';
  document.getElementById('editProductBrand').value = product.brand || '';
  document.getElementById('editProductCategory').value = product.category || '';
  document.getElementById('editProductGender').value = product.gender || 'Unisex';
  document.getElementById('editProductConcentration').value = product.concentration || 'Eau de Parfum';
  document.getElementById('editProductSize').value = product.size || '100ml';
  document.getElementById('editProductPrice').value = product.price || 0;
  document.getElementById('editProductCostPrice').value = product.costPrice || 0;
  document.getElementById('editProductStock').value = product.stock || 0;
  document.getElementById('editProductMinStock').value = product.minStockThreshold || 10;
  document.getElementById('editProductTopNotes').value = product.topNotes || '';
  document.getElementById('editProductHeartNotes').value = product.heartNotes || '';
  document.getElementById('editProductBaseNotes').value = product.baseNotes || '';
  document.getElementById('editProductDescription').value = product.description || '';

  const imageInput = document.getElementById('editProductImage');
  const imagePreview = document.getElementById('imagePreview');
  const placeholderWrapper = document.getElementById('imagePlaceholder');
  const samplePills = document.querySelectorAll('.sample-image-pill');

  if (imageInput) {
    imageInput.value = product.image || '';
    updateImagePreview(product.image);

    imageInput.addEventListener('input', e => {
      updateImagePreview(e.target.value);
    });
  }

  function updateImagePreview(url) {
    if (!imagePreview) return;
    if (url && url.trim().length > 5) {
      imagePreview.src = url.trim();
      imagePreview.classList.remove('d-none');
      if (placeholderWrapper) placeholderWrapper.classList.add('d-none');
    } else {
      imagePreview.classList.add('d-none');
      if (placeholderWrapper) placeholderWrapper.classList.remove('d-none');
    }
  }

  samplePills.forEach(pill => {
    pill.addEventListener('click', () => {
      const url = pill.getAttribute('data-img');
      if (imageInput && url) {
        imageInput.value = url;
        updateImagePreview(url);
      }
    });
  });

  // Breadcrumb / title update
  const titleNameEl = document.getElementById('editTitleFragranceName');
  if (titleNameEl) titleNameEl.textContent = product.name;

  const viewBtn = document.getElementById('btnViewCurrent');
  if (viewBtn) viewBtn.href = `view-product.html?id=${encodeURIComponent(product.id)}`;

  // Form submit handler
  const form = document.getElementById('editProductForm');
  if (form) {
    form.addEventListener('submit', event => {
      event.preventDefault();
      event.stopPropagation();

      if (!form.checkValidity()) {
        form.classList.add('was-validated');
        showToast('Please check the form for missing or invalid values.', 'warning');
        return;
      }

      const updatedFields = {
        name: (document.getElementById('editProductName').value || '').trim(),
        brand: (document.getElementById('editProductBrand').value || '').trim(),
        category: (document.getElementById('editProductCategory').value || '').trim(),
        gender: (document.getElementById('editProductGender').value || 'Unisex'),
        concentration: (document.getElementById('editProductConcentration').value || 'Eau de Parfum'),
        size: (document.getElementById('editProductSize').value || '100ml'),
        price: parseFloat(document.getElementById('editProductPrice').value) || 0,
        costPrice: parseFloat(document.getElementById('editProductCostPrice').value) || 0,
        stock: parseInt(document.getElementById('editProductStock').value, 10) || 0,
        minStockThreshold: parseInt(document.getElementById('editProductMinStock').value, 10) || 10,
        topNotes: (document.getElementById('editProductTopNotes').value || '').trim(),
        heartNotes: (document.getElementById('editProductHeartNotes').value || '').trim(),
        baseNotes: (document.getElementById('editProductBaseNotes').value || '').trim(),
        description: (document.getElementById('editProductDescription').value || '').trim(),
        image: (document.getElementById('editProductImage').value || '').trim()
      };

      try {
        const updated = PerfumeStore.update(product.id, updatedFields);
        showToast(`Fragrance <strong>${updated.name}</strong> was updated successfully!`, 'success');

        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
          submitBtn.disabled = true;
          submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving Updates...';
        }

        setTimeout(() => {
          window.location.href = `view-product.html?id=${encodeURIComponent(product.id)}`;
        }, 700);
      } catch (err) {
        showToast(err.message, 'danger');
      }
    });
  }
}

// ===================================================================
// 5. VIEW PRODUCT DETAILS PAGE CONTROLLER
// ===================================================================
function initViewProductPage() {
  const urlParams = new URLSearchParams(window.location.search);
  const productId = urlParams.get('id');

  if (!productId) {
    showToast('No fragrance ID provided to view.', 'warning');
    setTimeout(() => { window.location.href = 'products.html'; }, 1000);
    return;
  }

  const product = PerfumeStore.getById(productId);
  if (!product) {
    showToast(`Fragrance with ID "${productId}" not found.`, 'danger');
    setTimeout(() => { window.location.href = 'products.html'; }, 1200);
    return;
  }

  // Populate view fields
  const status = PerfumeStore.getStockStatus(product.stock, product.minStockThreshold);

  document.getElementById('detailImage').src = product.image || 'https://images.unsplash.com/photo-1547887537-6158d64c35b3?auto=format&fit=crop&w=800&q=80';
  document.getElementById('detailImage').alt = product.name;
  document.getElementById('detailName').textContent = product.name;
  document.getElementById('detailBrand').textContent = product.brand;
  document.getElementById('detailSku').textContent = product.id;
  document.getElementById('detailCategory').textContent = product.category;
  document.getElementById('detailConcentration').textContent = product.concentration;
  document.getElementById('detailGender').textContent = product.gender;
  document.getElementById('detailSize').textContent = product.size;
  document.getElementById('detailPrice').textContent = formatCurrency(product.price);
  
  const inventoryValue = (product.price || 0) * (product.stock || 0);
  document.getElementById('detailInventoryValue').textContent = formatCurrency(inventoryValue);

  // Status & Stock
  const statusEl = document.getElementById('detailStatusBadge');
  if (statusEl) {
    statusEl.className = `badge-status ${status.badgeClass}`;
    statusEl.innerHTML = `<span class="status-dot"></span> ${status.label}`;
  }
  document.getElementById('detailStock').textContent = `${product.stock} units`;
  document.getElementById('detailMinThreshold').textContent = `${product.minStockThreshold || 10} units`;

  // Olfactory notes
  document.getElementById('detailTopNotes').textContent = product.topNotes || 'Citrus, aromatic accents';
  document.getElementById('detailHeartNotes').textContent = product.heartNotes || 'Floral, spicy heart';
  document.getElementById('detailBaseNotes').textContent = product.baseNotes || 'Woody, amber, musky base';

  // Description
  document.getElementById('detailDescription').textContent = product.description || 'No detailed olfactory description provided.';

  // Created & Updated
  const createdDate = product.createdAt ? new Date(product.createdAt).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'N/A';
  document.getElementById('detailCreatedAt').textContent = createdDate;

  // Edit button target
  const editBtn = document.getElementById('btnEditFragrance');
  if (editBtn) {
    editBtn.href = `edit-product.html?id=${encodeURIComponent(product.id)}`;
  }

  // Delete button
  const deleteBtn = document.getElementById('btnDeleteFragrance');
  if (deleteBtn) {
    deleteBtn.onclick = () => {
      openDeleteModal(product.id, product.name);
    };
  }

  setupDeleteModal(() => {
    window.location.href = 'products.html';
  });
}

// DOM Content Loaded Router
document.addEventListener('DOMContentLoaded', () => {
  highlightActiveNavLink();

  const page = document.body.getAttribute('data-page');
  switch (page) {
    case 'dashboard':
      initDashboardPage();
      break;
    case 'products':
      initProductsPage();
      break;
    case 'add-product':
      initAddProductPage();
      break;
    case 'edit-product':
      initEditProductPage();
      break;
    case 'view-product':
      initViewProductPage();
      break;
    default:
      break;
  }
});
