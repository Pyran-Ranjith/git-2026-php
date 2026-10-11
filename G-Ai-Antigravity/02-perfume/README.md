# K-gi Perfume — Multi-Page Bootstrap 5 CRUD System

A responsive, multi-page **CRUD (Create, Read, Update, Delete)** web application built with **HTML5**, **CSS3**, **Bootstrap 5.3**, and **Vanilla JavaScript** with persistent `localStorage` synchronization.

Designed with a **Haute Parfumerie (Midnight Obsidian & Champagne Gold)** aesthetic tailored for luxury fragrance inventory management.

---

## 📁 Multi-Page Application Architecture

| Page | File | Primary CRUD Role | Features |
| :--- | :--- | :--- | :--- |
| **Dashboard** | [`index.html`](file:///e:/Users/Public/git_Html-Css-Js-bootstrap-2026/K-gi-perfume/index.html) | **Overview & Analytics** | Real-time KPI statistics (Total Fragrances, Units In Stock, Valuation, Alerts), Category distribution, Recent entries table |
| **Catalog / Inventory** | [`products.html`](file:///e:/Users/Public/git_Html-Css-Js-bootstrap-2026/K-gi-perfume/products.html) | **READ (List & Filter)** | Instant live search (by name, brand, SKU, notes), Olfactive family filter, Stock status filter, Multi-criteria sorting, Pagination, CSV & JSON exports |
| **Add Fragrance** | [`add-product.html`](file:///e:/Users/Public/git_Html-Css-Js-bootstrap-2026/K-gi-perfume/add-product.html) | **CREATE** | Auto-generated SKU, Bootstrap validation, Retail price & wholesale cost, Stock threshold alerts, 3-tier Olfactory notes (Top, Heart, Base), Live image preview & quick sample presets |
| **Edit Fragrance** | [`edit-product.html`](file:///e:/Users/Public/git_Html-Css-Js-bootstrap-2026/K-gi-perfume/edit-product.html) | **UPDATE** | Reads `?id=...` parameter, pre-populates all inputs, preserves SKU identity, live bottle image preview, instant validation |
| **Fragrance Details** | [`view-product.html`](file:///e:/Users/Public/git_Html-Css-Js-bootstrap-2026/K-gi-perfume/view-product.html) | **READ (Single Spec)** | Detailed bottle visual, Olfactory Pyramid (Top / Heart / Base notes), Batch inventory worth, dynamic stock pulse badges, direct Edit and Delete actions |

---

## 🛠️ Project Structure

```
K-gi-perfume/
├── index.html            # Dashboard & Analytics
├── products.html         # Full catalog table with search, filters & pagination
├── add-product.html      # Create new fragrance profile
├── edit-product.html     # Update fragrance profile
├── view-product.html     # Single fragrance specification view
├── css/
│   └── style.css         # Custom styling (Midnight Obsidian & Champagne Gold theme)
├── js/
│   ├── storage.js        # Data layer: Pre-seeded luxury catalog & CRUD functions
│   └── app.js            # UI controller, routing, toasts, search & filter logic
└── README.md             # Documentation
```

---

## 💎 Key Features

1. **Full CRUD Operations**:
   - **Create**: Add new fragrances with olfactive accords, volume sizes, pricing, and photo URL.
   - **Read**: Browse dashboard KPIs, paginated tabular inventory, or individual perfume specification sheets.
   - **Update**: Edit any existing product attributes with immediate persistent reflection across all pages.
   - **Delete**: Safe deletion with custom modal confirmation and feedback toast notifications.

2. **Persistent Storage & Pre-seeded Sample Data**:
   - Uses browser `localStorage` (`kgi_perfume_inventory_v1`).
   - Comes pre-loaded with **8 luxury fragrance profiles** (featuring photography from Unsplash, top/heart/base notes, and varying stock levels).
   - "Reset Samples" button in the catalog to restore initial sample data anytime.

3. **Live Search, Filter & Sort**:
   - Real-time search by Title, Brand, SKU, Olfactive Family, or Fragrance Notes.
   - Filter by Fragrance Family (Woody, Floral, Oriental, Fresh, Gourmand).
   - Filter by Stock Status (In Stock, Low Stock, Out of Stock).
   - Sort by Newest, Name (A-Z / Z-A), Price, or Stock count.

4. **Data Portability**:
   - Export full inventory data to **CSV** (for Excel/Google Sheets).
   - Export raw catalog backup to **JSON**.

5. **Luxury UI / UX Design**:
   - Built on **Bootstrap 5.3.3** + custom typography (**Cinzel** serif & **Plus Jakarta Sans**).
   - Glassmorphism surfaces, subtle amber gold borders, and glowing stock status indicators.
   - Fully responsive for mobile devices, tablets, and desktop displays.

---

## 🚀 How to Run the Project

1. **Option A: Using VS Code Live Server (Recommended)**:
   - Right-click [`index.html`](file:///e:/Users/Public/git_Html-Css-Js-bootstrap-2026/K-gi-perfume/index.html) in VS Code.
   - Click **"Open with Live Server"**.

2. **Option B: Direct Browser Open**:
   - Double-click [`index.html`](file:///e:/Users/Public/git_Html-Css-Js-bootstrap-2026/K-gi-perfume/index.html) in File Explorer to launch directly in any modern browser (Chrome, Edge, Firefox).
