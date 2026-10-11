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
            <li class="breadcrumb-item"><a href="products.php" class="text-gold text-decoration-none">Catalog</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Fragrance Specification</li>
          </ol>
        </nav>
        <h1 class="brand-font h2 fw-bold text-white mb-0" id="detailName">Loading Fragrance...</h1>
      </div>
      <div class="d-flex gap-2">
        <button id="btnDeleteFragrance" class="btn btn-outline-danger btn-sm px-3">
          <i class="bi bi-trash me-1"></i> Delete Fragrance
        </button>
      </div>
    </div>
  </div>
</header>

<!-- Main Container -->
<main class="container mb-5">
  <div class="row g-4">
    <!-- Left Column: Bottle Showcase & Inventory Metrics (5 cols) -->
    <div class="col-lg-5">
      <!-- Bottle Presentation Card -->
      <div class="luxury-card p-3 mb-4 text-center">
        <div style="height: 380px; border-radius: 10px; overflow: hidden; background: #0b0e12; display: flex; align-items: center; justify-content: center;">
          <img id="detailImage" src="" alt="Fragrance Bottle" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
      </div>

      <!-- Inventory Stock Metrics Card -->
      <div class="luxury-card p-4">
        <h5 class="brand-font text-gold mb-3">
          <i class="bi bi-box-seam me-2"></i> Vault & Inventory Status
        </h5>
        <div class="row g-3">
          <div class="col-6">
            <div class="text-muted small">Current Stock</div>
            <div class="h4 text-white fw-bold mt-1" id="detailStock">0 units</div>
          </div>
          <div class="col-6">
            <div class="text-muted small">Status</div>
            <div class="mt-1">
              <span id="detailStatusBadge" class="badge-status">
                <span class="status-dot"></span> Checking...
              </span>
            </div>
          </div>
          <div class="col-6">
            <div class="text-muted small">Threshold Alert</div>
            <div class="text-light mt-1" id="detailMinThreshold">10 units</div>
          </div>
          <div class="col-6">
            <div class="text-muted small">Total Batch Value</div>
            <div class="text-gold fw-bold mt-1" id="detailInventoryValue">$0.00</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Specs, Notes & Story (7 cols) -->
    <div class="col-lg-7">
      <!-- Overview Card -->
      <div class="luxury-card p-4 mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
          <span class="badge bg-warning bg-opacity-10 text-gold border border-warning border-opacity-25 px-3 py-1 rounded-pill" id="detailBrand">
            K-gi Maison
          </span>
          <code class="text-gold bg-dark px-2 py-1 rounded border border-dark-subtle" id="detailSku">SKU-000</code>
        </div>

        <div class="d-flex align-items-baseline gap-3 my-3">
          <h2 class="display-6 fw-bold text-gold mb-0" id="detailPrice">$0.00</h2>
          <span class="text-muted">MSRP / Bottle</span>
        </div>

        <!-- Specs Matrix -->
        <div class="row g-3 py-3 border-top border-bottom border-secondary border-opacity-10">
          <div class="col-sm-6 col-md-3">
            <div class="text-muted small text-uppercase">Family</div>
            <div class="fw-semibold text-light mt-1" id="detailCategory">-</div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="text-muted small text-uppercase">Concentration</div>
            <div class="fw-semibold text-light mt-1" id="detailConcentration">-</div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="text-muted small text-uppercase">Gender</div>
            <div class="fw-semibold text-light mt-1" id="detailGender">-</div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="text-muted small text-uppercase">Volume</div>
            <div class="fw-semibold text-light mt-1" id="detailSize">-</div>
          </div>
        </div>
      </div>

      <!-- Olfactory Pyramid Card -->
      <div class="luxury-card p-4 mb-4">
        <h5 class="brand-font text-gold mb-4">
          <i class="bi bi-layers-half me-2"></i> The Olfactory Pyramid
        </h5>

        <!-- Top Notes -->
        <div class="scent-pyramid-tier">
          <h6>Top Notes &bull; Head Accord (First 15 mins)</h6>
          <p id="detailTopNotes">-</p>
        </div>

        <!-- Heart Notes -->
        <div class="scent-pyramid-tier">
          <h6>Heart Notes &bull; Heart Accord (2 - 4 hours)</h6>
          <p id="detailHeartNotes">-</p>
        </div>

        <!-- Base Notes -->
        <div class="scent-pyramid-tier mb-0">
          <h6>Base Notes &bull; Dry Down & Trail (6+ hours)</h6>
          <p id="detailBaseNotes">-</p>
        </div>
      </div>

      <!-- Description Card -->
      <div class="luxury-card p-4 mb-4">
        <h5 class="brand-font text-gold mb-3">
          <i class="bi bi-book me-2"></i> The Narrative
        </h5>
        <p class="text-light lh-lg mb-3" id="detailDescription">-</p>
        <div class="text-muted small">
          <i class="bi bi-calendar3 me-1"></i> Formulated / Registered into catalog on: <span id="detailCreatedAt" class="text-light">-</span>
        </div>
      </div>

      <!-- Quick actions -->
      <div class="d-flex align-items-center gap-3">
        <a href="products.php" class="btn btn-dark-subtle px-4">
          <i class="bi bi-arrow-left me-1"></i> Return to Catalog
        </a>
        <a id="btnBottomEdit" href="#" class="btn btn-gold px-4" onclick="document.getElementById('btnEditFragrance').click(); return false;">
          <i class="bi bi-pencil-square me-1"></i> Edit Specifications
        </a>
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
        <small class="text-muted mt-2 d-block">This action cannot be reversed. You will be redirected back to the catalog.</small>
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