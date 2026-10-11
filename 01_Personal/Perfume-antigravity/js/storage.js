/**
 * K-gi Perfume CRUD System - Data Storage & Model Layer
 * Manages localStorage persistence, seed data, and CRUD operations.
 */

const STORAGE_KEY = 'kgi_perfume_inventory_v1';

// Initial pre-seeded luxury perfume catalog
const INITIAL_PRODUCTS = [
  {
    id: 'KGI-001',
    name: 'Noir Elegance Extrait',
    brand: 'K-gi Privé',
    category: 'Oriental & Spicy',
    gender: 'Unisex',
    concentration: 'Extrait de Parfum',
    size: '100ml',
    price: 240.00,
    costPrice: 85.00,
    stock: 45,
    minStockThreshold: 15,
    topNotes: 'Black Pepper, Cardamom, Bergamot',
    heartNotes: 'Smoky Rose, Incense, Leather',
    baseNotes: 'Dark Amber, Agarwood (Oud), Vanilla',
    description: 'An enigmatic, luxurious evening fragrance designed for sovereign presence. Blended with rare aged Cambodian oud and velvety smoked amber.',
    image: 'https://images.unsplash.com/photo-1547887537-6158d64c35b3?auto=format&fit=crop&w=800&q=80',
    createdAt: '2026-01-15T10:00:00.000Z'
  },
  {
    id: 'KGI-002',
    name: 'Velvet Rose & Oud',
    brand: 'K-gi Atelier',
    category: 'Floral & Romantic',
    gender: 'For Her',
    concentration: 'Eau de Parfum',
    size: '100ml',
    price: 195.00,
    costPrice: 70.00,
    stock: 12,
    minStockThreshold: 15,
    topNotes: 'Damask Rose, Clove, Saffron',
    heartNotes: 'Peony, Violet, Cashmeran',
    baseNotes: 'Oud, Praline, Sandalwood',
    description: 'A decadent bouquet of rich Damascene roses swirled with creamy praline and regal agarwood. Romantic, intoxicating, and lingering.',
    image: 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=800&q=80',
    createdAt: '2026-02-01T14:30:00.000Z'
  },
  {
    id: 'KGI-003',
    name: 'Santal Imperial',
    brand: 'K-gi Maison',
    category: 'Woody & Earthy',
    gender: 'Unisex',
    concentration: 'Eau de Parfum',
    size: '50ml',
    price: 165.00,
    costPrice: 55.00,
    stock: 28,
    minStockThreshold: 10,
    topNotes: 'Australian Cardamom, Papyrus',
    heartNotes: 'Iris, Violet, White Cedar',
    baseNotes: 'Mysore Sandalwood, Ambergris, Leather',
    description: 'Comforting yet distinctively aristocratic woody essence with creamy milky sandalwood and velvety violet blossoms.',
    image: 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&w=800&q=80',
    createdAt: '2026-02-18T09:15:00.000Z'
  },
  {
    id: 'KGI-004',
    name: 'Aqua Di Riviera',
    brand: 'K-gi Atelier',
    category: 'Fresh & Citrus',
    gender: 'Unisex',
    concentration: 'Eau de Toilette',
    size: '100ml',
    price: 135.00,
    costPrice: 42.00,
    stock: 64,
    minStockThreshold: 20,
    topNotes: 'Calabrian Bergamot, Sea Salt, Bitter Orange',
    heartNotes: 'Neroli, Rosemary, Jasmine',
    baseNotes: 'Driftwood, White Musk, Cedar',
    description: 'A crystalline sunburst reminiscent of a yacht cruise along the Amalfi Coast. Crisp marine notes kissed with effervescent citrus.',
    image: 'https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=800&q=80',
    createdAt: '2026-03-05T16:45:00.000Z'
  },
  {
    id: 'KGI-005',
    name: 'Amber Sovereign',
    brand: 'K-gi Privé',
    category: 'Oriental & Spicy',
    gender: 'For Him',
    concentration: 'Extrait de Parfum',
    size: '100ml',
    price: 260.00,
    costPrice: 90.00,
    stock: 4,
    minStockThreshold: 10,
    topNotes: 'Golden Saffron, Nutmeg, Cinnamon',
    heartNotes: 'Tobacco Leaf, Honeycomb, Tonka Bean',
    baseNotes: 'Golden Amber, Benzoin, French Labdanum',
    description: 'A regal, warm elixir radiating molten amber, aromatic tobacco, and spiced golden honey for an authoritative trail.',
    image: 'https://images.unsplash.com/photo-1588405748880-12d1d2a59f75?auto=format&fit=crop&w=800&q=80',
    createdAt: '2026-03-12T11:20:00.000Z'
  },
  {
    id: 'KGI-006',
    name: 'Vanilla Blanche Gourmande',
    brand: 'K-gi Maison',
    category: 'Gourmand & Sweet',
    gender: 'For Her',
    concentration: 'Eau de Parfum',
    size: '50ml',
    price: 155.00,
    costPrice: 50.00,
    stock: 0,
    minStockThreshold: 10,
    topNotes: 'Almond Milk, Whipped Cream',
    heartNotes: 'Bourbon Vanilla Orchid, Heliotrope',
    baseNotes: 'Madagascar Vanilla Pod, White Cocoa, Amber',
    description: 'Indulgent pure vanilla bean infused with buttery almond and silky white musk. Warm, cozy, and delightfully addictive.',
    image: 'https://images.unsplash.com/photo-1616949755610-8c9bbc08f138?auto=format&fit=crop&w=800&q=80',
    createdAt: '2026-03-20T13:00:00.000Z'
  },
  {
    id: 'KGI-007',
    name: 'Midnight Cypress & Vetiver',
    brand: 'K-gi Atelier',
    category: 'Woody & Earthy',
    gender: 'For Him',
    concentration: 'Eau de Parfum',
    size: '100ml',
    price: 180.00,
    costPrice: 60.00,
    stock: 31,
    minStockThreshold: 12,
    topNotes: 'Italian Cypress, Juniper Berries',
    heartNotes: 'Haitian Vetiver, Sage, Nutmeg',
    baseNotes: 'Oakmoss, Patchouli, Cashmere Wood',
    description: 'Dark, grounding forest canopy after midnight rain. Deep earthy vetiver balanced with sharp aromatic cypress needles.',
    image: 'https://images.unsplash.com/photo-1595425970377-c9703cf48b6d?auto=format&fit=crop&w=800&q=80',
    createdAt: '2026-04-01T08:50:00.000Z'
  },
  {
    id: 'KGI-008',
    name: 'Solar Fleur Magnolia',
    brand: 'K-gi Maison',
    category: 'Floral & Romantic',
    gender: 'For Her',
    concentration: 'Eau de Parfum',
    size: '30ml',
    price: 110.00,
    costPrice: 35.00,
    stock: 19,
    minStockThreshold: 8,
    topNotes: 'Sparkling Yuzu, White Peach',
    heartNotes: 'Grandiflora Magnolia, Tuberose, Frangipani',
    baseNotes: 'Sun-warmed Woods, Sheer Musk',
    description: 'Luminous solar floral capturing the intoxicating radiance of blooming southern magnolias on a warm sunlit afternoon.',
    image: 'https://images.unsplash.com/photo-1582211594533-268f4f1edcb9?auto=format&fit=crop&w=800&q=80',
    createdAt: '2026-04-10T17:10:00.000Z'
  }
];

// Product Data Service Object
const PerfumeStore = {
  /**
   * Initializes local storage with seed data if not present.
   */
  init() {
    if (!localStorage.getItem(STORAGE_KEY)) {
      this.resetToDefaults();
    }
  },

  /**
   * Resets local storage to initial catalog
   */
  resetToDefaults() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(INITIAL_PRODUCTS));
    return [...INITIAL_PRODUCTS];
  },

  /**
   * Returns all products
   * @returns {Array} List of product objects
   */
  getAll() {
    this.init();
    try {
      const data = localStorage.getItem(STORAGE_KEY);
      return data ? JSON.parse(data) : [];
    } catch (e) {
      console.error('Failed to parse perfume inventory from localStorage', e);
      return [];
    }
  },

  /**
   * Retrieves a single product by ID
   * @param {string} id
   * @returns {Object|null}
   */
  getById(id) {
    if (!id) return null;
    const products = this.getAll();
    return products.find(item => String(item.id).trim().toLowerCase() === String(id).trim().toLowerCase()) || null;
  },

  /**
   * Generates a unique product SKU / ID
   * @returns {string} e.g. KGI-009
   */
  generateId() {
    const products = this.getAll();
    const numbers = products
      .map(p => {
        const match = p.id.match(/\d+/);
        return match ? parseInt(match[0], 10) : 0;
      })
      .filter(n => !isNaN(n));

    const nextNum = numbers.length > 0 ? Math.max(...numbers) + 1 : 1;
    return `KGI-${String(nextNum).padStart(3, '0')}`;
  },

  /**
   * Adds a new product (CREATE)
   * @param {Object} product
   * @returns {Object} Added product
   */
  create(product) {
    const products = this.getAll();
    const newProduct = {
      ...product,
      id: product.id && product.id.trim() ? product.id.trim().toUpperCase() : this.generateId(),
      price: parseFloat(product.price) || 0,
      costPrice: parseFloat(product.costPrice) || 0,
      stock: parseInt(product.stock, 10) || 0,
      minStockThreshold: parseInt(product.minStockThreshold, 10) || 10,
      image: product.image && product.image.trim()
        ? product.image.trim()
        : 'https://images.unsplash.com/photo-1547887537-6158d64c35b3?auto=format&fit=crop&w=800&q=80',
      createdAt: new Date().toISOString()
    };

    // Check if ID already exists
    const exists = products.some(p => p.id.toLowerCase() === newProduct.id.toLowerCase());
    if (exists) {
      throw new Error(`Product with ID "${newProduct.id}" already exists.`);
    }

    products.unshift(newProduct);
    localStorage.setItem(STORAGE_KEY, JSON.stringify(products));
    return newProduct;
  },

  /**
   * Updates an existing product (UPDATE)
   * @param {string} id
   * @param {Object} updatedFields
   * @returns {Object} Updated product
   */
  update(id, updatedFields) {
    const products = this.getAll();
    const index = products.findIndex(p => String(p.id).toLowerCase() === String(id).toLowerCase());

    if (index === -1) {
      throw new Error(`Product with ID "${id}" was not found.`);
    }

    const current = products[index];
    const updated = {
      ...current,
      ...updatedFields,
      id: current.id, // Preserve ID
      price: parseFloat(updatedFields.price !== undefined ? updatedFields.price : current.price) || 0,
      costPrice: parseFloat(updatedFields.costPrice !== undefined ? updatedFields.costPrice : current.costPrice) || 0,
      stock: parseInt(updatedFields.stock !== undefined ? updatedFields.stock : current.stock, 10) || 0,
      minStockThreshold: parseInt(updatedFields.minStockThreshold !== undefined ? updatedFields.minStockThreshold : current.minStockThreshold, 10) || 10,
      updatedAt: new Date().toISOString()
    };

    products[index] = updated;
    localStorage.setItem(STORAGE_KEY, JSON.stringify(products));
    return updated;
  },

  /**
   * Deletes a product by ID (DELETE)
   * @param {string} id
   * @returns {boolean}
   */
  delete(id) {
    const products = this.getAll();
    const filtered = products.filter(p => String(p.id).toLowerCase() !== String(id).toLowerCase());

    if (filtered.length === products.length) {
      return false;
    }

    localStorage.setItem(STORAGE_KEY, JSON.stringify(filtered));
    return true;
  },

  /**
   * Computes stock status badge & label
   * @param {number} stock
   * @param {number} threshold
   * @returns {{label: string, badgeClass: string}}
   */
  getStockStatus(stock, threshold = 10) {
    if (stock <= 0) {
      return { label: 'Out of Stock', badgeClass: 'bg-danger text-white' };
    }
    if (stock <= threshold) {
      return { label: 'Low Stock', badgeClass: 'bg-warning text-dark' };
    }
    return { label: 'In Stock', badgeClass: 'bg-success text-white' };
  },

  /**
   * Computes aggregate business statistics for dashboard
   */
  getStats() {
    const products = this.getAll();
    const totalItems = products.length;
    const totalInventoryCount = products.reduce((acc, p) => acc + (parseInt(p.stock, 10) || 0), 0);
    const totalInventoryValue = products.reduce((acc, p) => acc + ((p.price || 0) * (p.stock || 0)), 0);
    const lowStockItems = products.filter(p => p.stock > 0 && p.stock <= (p.minStockThreshold || 10));
    const outOfStockItems = products.filter(p => p.stock <= 0);

    // Categories breakdown
    const categoriesMap = {};
    products.forEach(p => {
      const cat = p.category || 'Uncategorized';
      categoriesMap[cat] = (categoriesMap[cat] || 0) + 1;
    });

    return {
      totalItems,
      totalInventoryCount,
      totalInventoryValue,
      lowStockCount: lowStockItems.length,
      outOfStockCount: outOfStockItems.length,
      categoriesMap,
      recentProducts: products.slice(0, 5)
    };
  },

  /**
   * Exports catalog to downloadable JSON
   */
  exportJSON() {
    const dataStr = 'data:text/json;charset=utf-8,' + encodeURIComponent(JSON.stringify(this.getAll(), null, 2));
    const dlAnchorElem = document.createElement('a');
    dlAnchorElem.setAttribute('href', dataStr);
    dlAnchorElem.setAttribute('download', `kgi-perfumes-catalog-${new Date().toISOString().slice(0, 10)}.json`);
    dlAnchorElem.click();
  },

  /**
   * Exports catalog to CSV
   */
  exportCSV() {
    const products = this.getAll();
    if (products.length === 0) return;

    const headers = ['ID', 'Name', 'Brand', 'Category', 'Gender', 'Concentration', 'Size', 'Price', 'Stock', 'Top Notes', 'Heart Notes', 'Base Notes'];
    const rows = products.map(p => [
      `"${p.id || ''}"`,
      `"${(p.name || '').replace(/"/g, '""')}"`,
      `"${(p.brand || '').replace(/"/g, '""')}"`,
      `"${(p.category || '').replace(/"/g, '""')}"`,
      `"${p.gender || ''}"`,
      `"${p.concentration || ''}"`,
      `"${p.size || ''}"`,
      p.price || 0,
      p.stock || 0,
      `"${(p.topNotes || '').replace(/"/g, '""')}"`,
      `"${(p.heartNotes || '').replace(/"/g, '""')}"`,
      `"${(p.baseNotes || '').replace(/"/g, '""')}"`
    ]);

    const csvContent = 'data:text/csv;charset=utf-8,' + [headers.join(','), ...rows.map(e => e.join(','))].join('\n');
    const dlAnchorElem = document.createElement('a');
    dlAnchorElem.setAttribute('href', encodeURI(csvContent));
    dlAnchorElem.setAttribute('download', `kgi-perfumes-catalog-${new Date().toISOString().slice(0, 10)}.csv`);
    dlAnchorElem.click();
  }
};

// Auto initialize on load
PerfumeStore.init();
