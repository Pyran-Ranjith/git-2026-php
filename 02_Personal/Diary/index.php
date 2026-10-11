<?php
include_once 'include/header.php';
?>
  
<!-- <noscript> -->
  <!-- Hero Header -->
  <header class="py-4 border-bottom border-secondary border-opacity-10 mb-4">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-7">
          <span class="badge bg-warning bg-opacity-10 text-gold border border-warning border-opacity-25 px-3 py-1 rounded-pill mb-2">
            <i class="bi bi-gem me-1"></i> Haute Parfumerie Management
          </span>
          <h1 class="brand-font h2 fw-bold text-white mb-1">Fragrance Inventory Dashboard</h1>
          <p class="text-muted mb-0">Real-time luxury scent catalog analytics, stock monitoring, and inventory records.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
          <a href="add-product.php" class="btn btn-gold me-2">
            <i class="bi bi-plus-circle me-1"></i> Add New Scent
          </a>
          <a href="products.php" class="btn btn-dark-subtle">
            <i class="bi bi-arrow-right me-1"></i> View All Items
          </a>
        </div>
      </div>
    </div>
  </header>

<!-- Main Container -->
  <main class="container mb-5">
    <!-- Stat / KPI Cards -->
    <div class="row g-3 mb-4">
      <div class="col-sm-6 col-lg-3">
        <div class="luxury-card stat-card h-100">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="stat-label">Total Fragrances</div>
              <div class="stat-value" id="statTotalProducts">0</div>
            </div>
            <div class="stat-icon bg-warning bg-opacity-10 text-gold">
              <i class="bi bi-flower1"></i>
            </div>
          </div>
          <div class="mt-3 text-muted small">
            <i class="bi bi-check-circle-fill text-success me-1"></i> Distinct bespoke formulations
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="luxury-card stat-card h-100">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="stat-label">Bottles in Stock</div>
              <div class="stat-value" id="statTotalUnits">0</div>
            </div>
            <div class="stat-icon bg-info bg-opacity-10 text-info">
              <i class="bi bi-boxes"></i>
            </div>
          </div>
          <div class="mt-3 text-muted small">
            <i class="bi bi-shield-check text-info me-1"></i> Stored in climate-vault
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="luxury-card stat-card h-100">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="stat-label">Total Catalog Value</div>
              <div class="stat-value text-gold" id="statInventoryValue">$0.00</div>
            </div>
            <div class="stat-icon bg-success bg-opacity-10 text-success">
              <i class="bi bi-cash-stack"></i>
            </div>
          </div>
          <div class="mt-3 text-muted small">
            <i class="bi bi-graph-up-arrow text-success me-1"></i> Retail retail valuation
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="luxury-card stat-card h-100">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="stat-label">Stock Alerts</div>
              <div class="stat-value text-warning" id="statLowStock">0</div>
            </div>
            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
              <i class="bi bi-bell-fill"></i>
            </div>
          </div>
          <div class="mt-3 text-muted small">
            <i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> Requires replenishment
          </div>
        </div>
      </div>
    </div>

    <!-- Content Row -->
    <div class="row g-4">
      <!-- Left: Recent Fragrances Table -->
      <div class="col-lg-8">
        <div class="luxury-card p-3 p-md-4">
          <div class="d-flex flex-wrap align-items-center justify-content-between pb-3 mb-3 border-bottom border-secondary border-opacity-10 gap-2">
            <div>
              <h5 class="brand-font text-white mb-0">Recently Added Scents</h5>
              <small class="text-muted">Latest haute creations in the vault</small>
            </div>
            <a href="products.php" class="btn btn-outline-gold btn-sm">
              View All <i class="bi bi-arrow-right ms-1"></i>
            </a>
          </div>

          <div class="table-responsive">
            <table class="table-luxury">
              <thead>
                <tr>
                  <th>Fragrance</th>
                  <th>SKU</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Stock Status</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody id="recentProductsTableBody">
                <!-- Dynamically populated via js/app.js -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Right: Category Distribution & Quick Links -->
      <div class="col-lg-4">
        <!-- Categories Card -->
        <div class="luxury-card p-4 mb-4">
          <h5 class="brand-font text-white mb-1">Fragrance Families</h5>
          <p class="text-muted small mb-3">Distribution by olfactive family</p>
          <div id="categoryBreakdownList">
            <!-- Dynamically populated via js/app.js -->
          </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="luxury-card p-4">
          <h5 class="brand-font text-white mb-3">Quick Actions</h5>
          <div class="d-grid gap-2">
            <a href="add-product.php" class="btn btn-gold text-start py-2">
              <i class="bi bi-plus-circle-fill me-2"></i> Create New Fragrance Record
            </a>
            <a href="products.php" class="btn btn-dark-subtle text-start py-2">
              <i class="bi bi-search me-2"></i> Search & Filter Inventory
            </a>
          </div>
        </div>
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
          <small class="text-muted mt-2 d-block">This action will remove the fragrance and all its olfactory notes from your catalog.</small>
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
<!-- </noscript> -->
<?php
include_once 'include/footer.php';
?>
