<?php
include_once 'include/header.php';
?>

  <!-- Page Header -->
  <header class="py-4 border-bottom border-secondary border-opacity-10 mb-4">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1 small">
          <li class="breadcrumb-item"><a href="index.html" class="text-gold text-decoration-none">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="products.html" class="text-gold text-decoration-none">Catalog</a></li>
          <li class="breadcrumb-item active text-muted" aria-current="page">Edit Fragrance</li>
        </ol>
      </nav>
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
          <h1 class="brand-font h2 fw-bold text-white mb-0">
            Edit Fragrance: <span id="editTitleFragranceName" class="text-gold">Loading...</span>
          </h1>
          <p class="text-muted mb-0">Modify sensory accords, inventory counts, retail pricing, or visual assets.</p>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Container -->
  <main class="container mb-5">
    <form id="editProductForm" novalidate>
      <div class="row g-4">
        <!-- Left: Form Input Fields (8 cols) -->
        <div class="col-lg-8">
          <!-- General Specs Card -->
          <div class="luxury-card p-4 mb-4">
            <h5 class="brand-font text-gold mb-3">
              <i class="bi bi-pencil-square me-2"></i> Profile & Specifications
            </h5>

            <div class="row g-3">
              <!-- SKU (Read-Only) -->
              <div class="col-md-4">
                <label for="editProductSku" class="form-label">SKU / Code</label>
                <input type="text" class="form-control form-control-luxury font-monospace" id="editProductSku" readonly disabled>
                <div class="form-text text-muted small">Unique SKU identifier (locked).</div>
              </div>

              <!-- Name -->
              <div class="col-md-8">
                <label for="editProductName" class="form-label">Fragrance Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-luxury" id="editProductName" required>
                <div class="invalid-feedback">Please enter the fragrance title.</div>
              </div>

              <!-- Brand House -->
              <div class="col-md-6">
                <label for="editProductBrand" class="form-label">Brand House <span class="text-danger">*</span></label>
                <select class="form-select form-select-luxury" id="editProductBrand" required>
                  <option value="K-gi Privé">K-gi Privé (Haute Collection)</option>
                  <option value="K-gi Maison">K-gi Maison (Signature Collection)</option>
                  <option value="K-gi Atelier">K-gi Atelier (Artisanal Line)</option>
                  <option value="K-gi Heritage">K-gi Heritage</option>
                </select>
              </div>

              <!-- Olfactive Family -->
              <div class="col-md-6">
                <label for="editProductCategory" class="form-label">Olfactive Family <span class="text-danger">*</span></label>
                <select class="form-select form-select-luxury" id="editProductCategory" required>
                  <option value="Oriental & Spicy">Oriental & Spicy</option>
                  <option value="Woody & Earthy">Woody & Earthy</option>
                  <option value="Floral & Romantic">Floral & Romantic</option>
                  <option value="Fresh & Citrus">Fresh & Citrus</option>
                  <option value="Gourmand & Sweet">Gourmand & Sweet</option>
                  <option value="Aromatic & Green">Aromatic & Green</option>
                </select>
              </div>

              <!-- Concentration -->
              <div class="col-md-4">
                <label for="editProductConcentration" class="form-label">Concentration</label>
                <select class="form-select form-select-luxury" id="editProductConcentration">
                  <option value="Extrait de Parfum">Extrait de Parfum (30-40%)</option>
                  <option value="Eau de Parfum">Eau de Parfum (15-20%)</option>
                  <option value="Eau de Toilette">Eau de Toilette (5-15%)</option>
                  <option value="Eau de Cologne">Eau de Cologne (2-4%)</option>
                </select>
              </div>

              <!-- Gender -->
              <div class="col-md-4">
                <label for="editProductGender" class="form-label">Classification</label>
                <select class="form-select form-select-luxury" id="editProductGender">
                  <option value="Unisex">Unisex / Genderless</option>
                  <option value="For Him">For Him / Masculine</option>
                  <option value="For Her">For Her / Feminine</option>
                </select>
              </div>

              <!-- Size -->
              <div class="col-md-4">
                <label for="editProductSize" class="form-label">Bottle Volume</label>
                <select class="form-select form-select-luxury" id="editProductSize">
                  <option value="100ml">100ml / 3.4 fl oz</option>
                  <option value="50ml">50ml / 1.7 fl oz</option>
                  <option value="30ml">30ml / 1.0 fl oz</option>
                  <option value="10ml Travel">10ml Travel Atomizer</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Pricing & Inventory Card -->
          <div class="luxury-card p-4 mb-4">
            <h5 class="brand-font text-gold mb-3">
              <i class="bi bi-tag me-2"></i> Pricing & Inventory Control
            </h5>

            <div class="row g-3">
              <!-- Retail Price -->
              <div class="col-md-6">
                <label for="editProductPrice" class="form-label">Retail Selling Price ($ USD) <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text input-group-text-luxury">$</span>
                  <input type="number" step="0.01" min="0" class="form-control form-control-luxury" id="editProductPrice" required>
                </div>
              </div>

              <!-- Cost Price -->
              <div class="col-md-6">
                <label for="editProductCostPrice" class="form-label">Production Cost ($ USD)</label>
                <div class="input-group">
                  <span class="input-group-text input-group-text-luxury">$</span>
                  <input type="number" step="0.01" min="0" class="form-control form-control-luxury" id="editProductCostPrice">
                </div>
              </div>

              <!-- Current Stock -->
              <div class="col-md-6">
                <label for="editProductStock" class="form-label">Current Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" min="0" class="form-control form-control-luxury" id="editProductStock" required>
              </div>

              <!-- Min Stock Threshold -->
              <div class="col-md-6">
                <label for="editProductMinStock" class="form-label">Low Stock Threshold</label>
                <input type="number" min="1" class="form-control form-control-luxury" id="editProductMinStock">
              </div>
            </div>
          </div>

          <!-- Olfactive Notes & Narrative -->
          <div class="luxury-card p-4 mb-4">
            <h5 class="brand-font text-gold mb-3">
              <i class="bi bi-flower2 me-2"></i> Olfactive Pyramid & Sensory Accords
            </h5>

            <div class="row g-3">
              <div class="col-12">
                <label for="editProductTopNotes" class="form-label">Top Notes (Opening Accord)</label>
                <input type="text" class="form-control form-control-luxury" id="editProductTopNotes">
              </div>

              <div class="col-12">
                <label for="editProductHeartNotes" class="form-label">Heart Notes (Core Character)</label>
                <input type="text" class="form-control form-control-luxury" id="editProductHeartNotes">
              </div>

              <div class="col-12">
                <label for="editProductBaseNotes" class="form-label">Base Notes (Dry Down & Sillage)</label>
                <input type="text" class="form-control form-control-luxury" id="editProductBaseNotes">
              </div>

              <div class="col-12">
                <label for="editProductDescription" class="form-label">Olfactory Description & Story</label>
                <textarea class="form-control form-control-luxury" id="editProductDescription" rows="3"></textarea>
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="d-flex align-items-center justify-content-between pt-2">
            <a href="products.html" class="btn btn-dark-subtle px-4">
              <i class="bi bi-x-circle me-1"></i> Discard Changes
            </a>
            <button type="submit" class="btn btn-gold px-5 py-2">
              <i class="bi bi-check2-circle me-1"></i> Update Fragrance
            </button>
          </div>
        </div>

        <!-- Right: Image Preview & Presets (4 cols) -->
        <div class="col-lg-4">
          <div class="luxury-card p-4 mb-4 sticky-top" style="top: 90px;">
            <h5 class="brand-font text-gold mb-3">
              <i class="bi bi-image me-2"></i> Bottle Presentation
            </h5>

            <div class="mb-3">
              <label for="editProductImage" class="form-label">Bottle Photography Image URL</label>
              <input type="url" class="form-control form-control-luxury" id="editProductImage">
            </div>

            <!-- Preview Container -->
            <div class="image-preview-wrapper mb-3">
              <img id="imagePreview" src="" alt="Live Preview">
              <div id="imagePlaceholder" class="image-preview-placeholder d-none">
                <i class="bi bi-image fs-1 d-block mb-1"></i>
                <small>Image preview will display here</small>
              </div>
            </div>

            <!-- Sample Image Presets -->
            <div class="mb-2">
              <span class="text-muted small d-block mb-2">Or pick a replacement bottle visual:</span>
              <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary sample-image-pill text-truncate" data-img="https://images.unsplash.com/photo-1547887537-6158d64c35b3?auto=format&fit=crop&w=800&q=80">
                  Amber Scent
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary sample-image-pill text-truncate" data-img="https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=800&q=80">
                  Rose Gold
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary sample-image-pill text-truncate" data-img="https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&w=800&q=80">
                  Crystal Flacon
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary sample-image-pill text-truncate" data-img="https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=800&q=80">
                  Azure Marine
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </main>

  <!-- Toast Container -->
  <div class="toast-container"></div>

<?php
include_once 'include/footer.php';
?>
