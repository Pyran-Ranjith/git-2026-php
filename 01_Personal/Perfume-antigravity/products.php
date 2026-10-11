<?php
include_once 'include/header.php';
?>

<!-- Page Header -->
<header class="py-4 border-bottom border-secondary border-opacity-10 mb-4">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-1 small">
            <li class="breadcrumb-item"><a href="index.php" class="text-gold text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Catalog</li>
          </ol>
        </nav>
        <h1 class="brand-font h2 fw-bold text-white mb-0">
          Fragrance Inventory & Catalog
          <span class="badge bg-warning bg-opacity-10 text-gold border border-warning border-opacity-25 fs-6 ms-2 py-1 px-2 align-middle" id="productCountBadge">
            Loading...
          </span>
        </h1>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <button id="btnResetCatalog" class="btn btn-outline-secondary btn-sm" title="Restore default sample scents">
          <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Samples
        </button>
        <a href="add-product.php" class="btn btn-gold btn-sm px-3">
          <i class="bi bi-plus-circle-fill me-1"></i> Add New Fragrance
        </a>
      </div>
    </div>
  </div>
</header>

<!-- Main Content Container -->
<main class="container mb-5">
  <!-- Filter, Search & Sorting Controls -->
  <div class="luxury-card p-3 p-md-4 mb-4">
    <div class="row g-3 align-items-center">
      <!-- Search bar -->
      <div class="col-lg-4 col-md-6">
        <label class="form-label small text-muted">Search Catalog</label>
        <div class="input-group">
          <span class="input-group-text input-group-text-luxury">
            <i class="bi bi-search"></i>
          </span>
          <input type="text" id="searchProductInput" class="form-control form-control-luxury" placeholder="Search by name, brand, SKU or note...">
        </div>
      </div>

      <!-- Category Filter -->
      <div class="col-lg-3 col-md-6">
        <label class="form-label small text-muted">Fragrance Family</label>
        <select id="filterCategory" class="form-select form-select-luxury">
          <option value="">All Fragrance Categories</option>
        </select>
      </div>

      <!-- Stock Status Filter -->
      <div class="col-lg-2 col-md-6">
        <label class="form-label small text-muted">Stock Status</label>
        <select id="filterStock" class="form-select form-select-luxury">
          <option value="">All Inventory</option>
          <option value="in_stock">In Stock</option>
          <option value="low_stock">Low Stock</option>
          <option value="out_of_stock">Out of Stock</option>
        </select>
      </div>

      <!-- Sort Filter -->
      <div class="col-lg-2 col-md-4">
        <label class="form-label small text-muted">Sort By</label>
        <select id="filterSort" class="form-select form-select-luxury">
          <option value="newest">Newest Added</option>
          <option value="name_asc">Name (A &rarr; Z)</option>
          <option value="name_desc">Name (Z &rarr; A)</option>
          <option value="price_asc">Price: Low to High</option>
          <option value="price_desc">Price: High to Low</option>
          <option value="stock_asc">Stock: Low to High</option>
          <option value="stock_desc">Stock: High to Low</option>
        </select>
      </div>

      <!-- Reset Filters button -->
      <div class="col-lg-1 col-md-2 d-flex align-items-end">
        <button id="resetFiltersBtn" class="btn btn-dark-subtle w-100" style="padding-top: 0.65rem; padding-bottom: 0.65rem;" title="Reset filters">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Inventory Table Card -->
  <div class="luxury-card p-3 p-md-4">
    <div class="table-responsive">
      <table class="table-luxury">
        <thead>
          <tr>
            <th style="min-width: 250px;">Fragrance Profile</th>
            <th>SKU / Code</th>
            <th>Olfactive Family</th>
            <th>Concentration & Size</th>
            <th>Unit Price</th>
            <th>Inventory Status</th>
            <th class="text-end" style="min-width: 130px;">Actions</th>
          </tr>
        </thead>
        <tbody id="productsTableBody">
          <!-- Dynamically populated via js/app.js -->
        </tbody>
      </table>
    </div>

    <!-- Empty State -->
    <div id="emptyStateWrapper" class="empty-state d-none">
      <i class="bi bi-search"></i>
      <h4 class="brand-font text-white mb-2">No Matching Fragrances</h4>
      <p class="text-muted mb-3">No perfumes in the inventory matched your current filter or search query.</p>
      <button class="btn btn-outline-gold btn-sm" onclick="document.getElementById('resetFiltersBtn').click()">
        <i class="bi bi-arrow-clockwise me-1"></i> Clear Search Filters
      </button>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
      <nav aria-label="Page navigation">
        <ul class="pagination pagination-luxury mb-0" id="productsPagination">
          <!-- Dynamically populated -->
        </ul>
      </nav>
    </div>
  </div>
</main>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-content-luxury">
      <div class="modal-header modal-header-luxury">
        <h5 class="modal-title brand-font text-danger" id="deleteModalLabel">
          <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Fragrance Removal
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <p class="text-light mb-2">Are you sure you want to permanently delete this fragrance from the database?</p>
        <div class="alert alert-dark border border-secondary p-3 mb-0">
          <strong class="text-gold" id="deleteProductName">Item Name</strong>
        </div>
        <small class="text-muted mt-2 d-block">This action cannot be undone. It will remove the item from all records.</small>
      </div>
      <div class="modal-footer modal-footer-luxury">
        <button type="button" class="btn btn-dark-subtle" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger px-4" id="confirmDeleteBtn">Delete Fragrance</button>
      </div>
    </div>
  </div>
</div>

<!-- Toast Container -->
<div class="toast-container"></div>

<!-- Footer -->
<?php
include_once 'include/footer.php';
?>