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
          <li class="breadcrumb-item active text-muted" aria-current="page">Add New Fragrance</li>
        </ol>
      </nav>
      <h1 class="brand-font h2 fw-bold text-white mb-0">Formulate New Fragrance Entry</h1>
      <p class="text-muted mb-0">Record a new creation with olfactive notes, pricing, bottle format, and initial vault stock.</p>
    </div>
  </header>

  <!-- Main Container -->
  <main class="container mb-5">
    <form id="addProductForm" novalidate>
      <div class="row g-4">
        <!-- Left: Fragrance Information Fields (8 cols) -->
        <div class="col-lg-8">
          <!-- General Specs Card -->
          <div class="luxury-card p-4 mb-4">
            <h5 class="brand-font text-gold mb-3">
              <i class="bi bi-info-circle me-2"></i> Fragrance Profile
            </h5>

            <div class="row g-3">
              <!-- SKU -->
              <div class="col-md-4">
                <label for="productSku" class="form-label">SKU / Code <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-luxury font-monospace" id="productSku" required>
                <div class="form-text text-muted small">Auto-generated unique identifier.</div>
              </div>

              <!-- Name -->
              <div class="col-md-8">
                <label for="productName" class="form-label">Fragrance Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-luxury" id="productName" placeholder="e.g. Noir Elegance Extrait" required>
                <div class="invalid-feedback">Please enter the fragrance title.</div>
              </div>

              <!-- Brand House -->
              <div class="col-md-6">
                <label for="productBrand" class="form-label">Brand House <span class="text-danger">*</span></label>
                <select class="form-select form-select-luxury" id="productBrand" required>
                  <option value="K-gi Privé" selected>K-gi Privé (Haute Collection)</option>
                  <option value="K-gi Maison">K-gi Maison (Signature Collection)</option>
                  <option value="K-gi Atelier">K-gi Atelier (Artisanal Line)</option>
                  <option value="K-gi Heritage">K-gi Heritage</option>
                </select>
              </div>

              <!-- Olfactive Family -->
              <div class="col-md-6">
                <label for="productCategory" class="form-label">Olfactive Family <span class="text-danger">*</span></label>
                <select class="form-select form-select-luxury" id="productCategory" required>
                  <option value="">Select Fragrance Family</option>
                  <option value="Oriental & Spicy">Oriental & Spicy</option>
                  <option value="Woody & Earthy">Woody & Earthy</option>
                  <option value="Floral & Romantic">Floral & Romantic</option>
                  <option value="Fresh & Citrus">Fresh & Citrus</option>
                  <option value="Gourmand & Sweet">Gourmand & Sweet</option>
                  <option value="Aromatic & Green">Aromatic & Green</option>
                </select>
                <div class="invalid-feedback">Please select an olfactive family.</div>
              </div>

              <!-- Concentration -->
              <div class="col-md-4">
                <label for="productConcentration" class="form-label">Concentration</label>
                <select class="form-select form-select-luxury" id="productConcentration">
                  <option value="Extrait de Parfum">Extrait de Parfum (30-40%)</option>
                  <option value="Eau de Parfum" selected>Eau de Parfum (15-20%)</option>
                  <option value="Eau de Toilette">Eau de Toilette (5-15%)</option>
                  <option value="Eau de Cologne">Eau de Cologne (2-4%)</option>
                </select>
              </div>

              <!-- Gender -->
              <div class="col-md-4">
                <label for="productGender" class="form-label">Classification</label>
                <select class="form-select form-select-luxury" id="productGender">
                  <option value="Unisex" selected>Unisex / Genderless</option>
                  <option value="For Him">For Him / Masculine</option>
                  <option value="For Her">For Her / Feminine</option>
                </select>
              </div>

              <!-- Size -->
              <div class="col-md-4">
                <label for="productSize" class="form-label">Bottle Volume</label>
                <select class="form-select form-select-luxury" id="productSize">
                  <option value="100ml" selected>100ml / 3.4 fl oz</option>
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
                <label for="productPrice" class="form-label">Retail Selling Price ($ USD) <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text input-group-text-luxury">$</span>
                  <input type="number" step="0.01" min="0" class="form-control form-control-luxury" id="productPrice" placeholder="185.00" required>
                </div>
                <div class="invalid-feedback">Please enter a valid price.</div>
              </div>

              <!-- Cost Price -->
              <div class="col-md-6">
                <label for="productCostPrice" class="form-label">Wholesale / Production Cost ($ USD)</label>
                <div class="input-group">
                  <span class="input-group-text input-group-text-luxury">$</span>
                  <input type="number" step="0.01" min="0" class="form-control form-control-luxury" id="productCostPrice" placeholder="60.00">
                </div>
              </div>

              <!-- Stock Quantity -->
              <div class="col-md-6">
                <label for="productStock" class="form-label">Initial Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" min="0" class="form-control form-control-luxury" id="productStock" placeholder="25" value="25" required>
                <div class="invalid-feedback">Please specify stock count.</div>
              </div>

              <!-- Min Stock Alert -->
              <div class="col-md-6">
                <label for="productMinStock" class="form-label">Low Stock Alert Threshold</label>
                <input type="number" min="1" class="form-control form-control-luxury" id="productMinStock" placeholder="10" value="10">
                <div class="form-text text-muted small">Alert triggered when stock falls at or below this level.</div>
              </div>
            </div>
          </div>

          <!-- Olfactory Pyramid & Notes -->
          <div class="luxury-card p-4 mb-4">
            <h5 class="brand-font text-gold mb-3">
              <i class="bi bi-flower2 me-2"></i> Olfactive Pyramid & Sensory Notes
            </h5>

            <div class="row g-3">
              <div class="col-12">
                <label for="productTopNotes" class="form-label">Top Notes (Opening Accord)</label>
                <input type="text" class="form-control form-control-luxury" id="productTopNotes" placeholder="e.g. Calabrian Bergamot, Pink Peppercorn, Saffron">
              </div>

              <div class="col-12">
                <label for="productHeartNotes" class="form-label">Heart Notes (Core Character)</label>
                <input type="text" class="form-control form-control-luxury" id="productHeartNotes" placeholder="e.g. Damask Rose, Tuscan Orris, Smoky Leather">
              </div>

              <div class="col-12">
                <label for="productBaseNotes" class="form-label">Base Notes (Dry Down & Sillage)</label>
                <input type="text" class="form-control form-control-luxury" id="productBaseNotes" placeholder="e.g. Aged Agarwood, Golden Amber, Bourbon Vanilla">
              </div>

              <div class="col-12">
                <label for="productDescription" class="form-label">Olfactory Description & Story</label>
                <textarea class="form-control form-control-luxury" id="productDescription" rows="3" placeholder="Compose the narrative and mood of this bespoke scent..."></textarea>
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="d-flex align-items-center justify-content-between pt-2">
            <a href="products.html" class="btn btn-dark-subtle px-4">
              <i class="bi bi-x-circle me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-gold px-5 py-2">
              <i class="bi bi-check-circle-fill me-1"></i> Save Fragrance
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
              <label for="productImage" class="form-label">Bottle Photography Image URL</label>
              <input type="url" class="form-control form-control-luxury" id="productImage" placeholder="https://images.unsplash.com/..." value="https://images.unsplash.com/photo-1547887537-6158d64c35b3?auto=format&fit=crop&w=800&q=80">
              <div class="form-text text-muted small">Paste an image link or select a sample below.</div>
            </div>

            <!-- Preview Container -->
            <div class="image-preview-wrapper mb-3">
              <img id="imagePreview" src="https://images.unsplash.com/photo-1547887537-6158d64c35b3?auto=format&fit=crop&w=800&q=80" alt="Live Preview">
              <div id="imagePlaceholder" class="image-preview-placeholder d-none">
                <i class="bi bi-image fs-1 d-block mb-1"></i>
                <small>Image preview will display here</small>
              </div>
            </div>

            <!-- Sample Image Presets -->
            <div class="mb-2">
              <span class="text-muted small d-block mb-2">Or choose a luxury bottle visual:</span>
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
