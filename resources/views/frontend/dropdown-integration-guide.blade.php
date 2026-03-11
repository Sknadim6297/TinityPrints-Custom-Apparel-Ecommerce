<!-- FRONTEND INTEGRATION GUIDE FOR DYNAMIC DROPDOWNS -->

<!-- Import this script in your frontend layout header -->
<script>
    // Fetch all dropdown data on page load
    function loadDropdownData() {
        return fetch('/api/dropdowns/all')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    return data.data;
                }
                throw new Error('Failed to load dropdown data');
            })
            .catch(error => {
                console.error('Error loading dropdowns:', error);
                return { categories: [], sleeveTypes: [], collectionTypes: [] };
            });
    }

    // Fetch specific dropdown
    function loadCategories() {
        return fetch('/api/dropdowns/categories')
            .then(response => response.json())
            .then(data => data.success ? data.data : [])
            .catch(error => {
                console.error('Error loading categories:', error);
                return [];
            });
    }

    function loadSleeveTypes() {
        return fetch('/api/dropdowns/sleeve-types')
            .then(response => response.json())
            .then(data => data.success ? data.data : [])
            .catch(error => {
                console.error('Error loading sleeve types:', error);
                return [];
            });
    }

    function loadCollectionTypes() {
        return fetch('/api/dropdowns/collection-types')
            .then(response => response.json())
            .then(data => data.success ? data.data : [])
            .catch(error => {
                console.error('Error loading collection types:', error);
                return [];
            });
    }
</script>

<!-- EXAMPLE 1: Simple Product Filter Form -->
<!-- Usage in your filter/search form -->
<div id="filter-container">
    <div class="filter-section">
        <label for="category-filter">Category</label>
        <select id="category-filter">
            <option value="">All Categories</option>
        </select>
    </div>

    <div class="filter-section">
        <label for="sleeve-filter">Sleeve Type</label>
        <select id="sleeve-filter">
            <option value="">All Sleeve Types</option>
        </select>
    </div>

    <div class="filter-section">
        <label for="collection-filter">Collection</label>
        <select id="collection-filter">
            <option value="">All Collections</option>
        </select>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const dropdownData = await loadDropdownData();
        
        // Populate category filter
        const categorySelect = document.getElementById('category-filter');
        dropdownData.categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.slug;
            option.textContent = category.name;
            categorySelect.appendChild(option);
        });

        // Populate sleeve type filter
        const sleeveSelect = document.getElementById('sleeve-filter');
        dropdownData.sleeveTypes.forEach(sleeveType => {
            const option = document.createElement('option');
            option.value = sleeveType.slug;
            option.textContent = sleeveType.name;
            sleeveSelect.appendChild(option);
        });

        // Populate collection filter
        const collectionSelect = document.getElementById('collection-filter');
        dropdownData.collectionTypes.forEach(collection => {
            const option = document.createElement('option');
            option.value = collection.slug;
            option.textContent = collection.name;
            collectionSelect.appendChild(option);
        });

        // Add event listeners for filtering
        categorySelect.addEventListener('change', filterProducts);
        sleeveSelect.addEventListener('change', filterProducts);
        collectionSelect.addEventListener('change', filterProducts);
    });

    function filterProducts() {
        const category = document.getElementById('category-filter').value;
        const sleeve = document.getElementById('sleeve-filter').value;
        const collection = document.getElementById('collection-filter').value;

        // Build query string
        const params = new URLSearchParams();
        if (category) params.append('category', category);
        if (sleeve) params.append('sleeve_type', sleeve);
        if (collection) params.append('collection_type', collection);

        // Redirect or fetch filtered results
        window.location.href = `/shop?${params.toString()}`;
    }
</script>

<!-- EXAMPLE 2: Display Product Details with Category/Sleeve Type -->
<div class="product-details">
    <h2 id="product-name"></h2>
    <p id="product-category"></p>
    <p id="product-sleeve"></p>
    <p id="product-collection"></p>
</div>

<script>
    // Example: Display product information
    async function displayProductDetails(productData) {
        // productData should include: category_id, sleeve_type_id, collection_type_id
        
        const dropdownData = await loadDropdownData();

        // Find category name
        const category = dropdownData.categories.find(c => c.id === productData.category_id);
        document.getElementById('product-category').textContent = 
            `Category: ${category?.name || 'N/A'}`;

        // Find sleeve type name
        const sleeve = dropdownData.sleeveTypes.find(s => s.id === productData.sleeve_type_id);
        document.getElementById('product-sleeve').textContent = 
            `Sleeve Type: ${sleeve?.name || 'N/A'}`;

        // Find collection type name
        if (productData.collection_type_id) {
            const collection = dropdownData.collectionTypes.find(c => c.id === productData.collection_type_id);
            document.getElementById('product-collection').textContent = 
                `Collection: ${collection?.name || 'N/A'}`;
        }
    }

    // Usage:
    // displayProductDetails({
    //     category_id: 1,
    //     sleeve_type_id: 2,
    //     collection_type_id: 3
    // });
</script>

<!-- EXAMPLE 3: Real-time Search/Filter with Dropdowns -->
<div class="advanced-filter">
    <input type="text" id="search-input" placeholder="Search products...">
    
    <select id="category-select" class="filter-select">
        <option value="">Select Category...</option>
    </select>

    <select id="sleeve-select" class="filter-select">
        <option value="">Select Sleeve Type...</option>
    </select>

    <select id="collection-select" class="filter-select">
        <option value="">Select Collection...</option>
    </select>

    <button id="apply-filters">Apply Filters</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const dropdownData = await loadDropdownData();

        // Populate all selects
        populateSelect('category-select', dropdownData.categories);
        populateSelect('sleeve-select', dropdownData.sleeveTypes);
        populateSelect('collection-select', dropdownData.collectionTypes);

        // Handle filter application
        document.getElementById('apply-filters').addEventListener('click', applyAdvancedFilters);
    });

    function populateSelect(selectId, options) {
        const select = document.getElementById(selectId);
        options.forEach(option => {
            const element = document.createElement('option');
            element.value = option.id;
            element.textContent = option.name;
            select.appendChild(element);
        });
    }

    function applyAdvancedFilters() {
        const search = document.getElementById('search-input').value;
        const category = document.getElementById('category-select').value;
        const sleeve = document.getElementById('sleeve-select').value;
        const collection = document.getElementById('collection-select').value;

        const params = new URLSearchParams();
        if (search) params.append('search', search);
        if (category) params.append('category_id', category);
        if (sleeve) params.append('sleeve_type_id', sleeve);
        if (collection) params.append('collection_type_id', collection);

        // Fetch filtered results
        fetch(`/api/products/search?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                // Update product display with filtered results
                displayFilteredProducts(data);
            });
    }

    function displayFilteredProducts(products) {
        // Implement your product display logic
        console.log('Filtered products:', products);
    }
</script>

<!-- API ENDPOINTS AVAILABLE FOR FRONTEND -->
<!--
GET /api/dropdowns/categories
    Returns: { success: true, data: [{ id, name, slug, description }, ...] }

GET /api/dropdowns/sleeve-types
    Returns: { success: true, data: [{ id, name, slug, description }, ...] }

GET /api/dropdowns/collection-types
    Returns: { success: true, data: [{ id, name, slug, description }, ...] }

GET /api/dropdowns/all
    Returns: {
        success: true,
        data: {
            categories: [...],
            sleeveTypes: [...],
            collectionTypes: [...]
        }
    }
-->

<!-- IMPORTANT NOTES FOR DEVELOPERS -->
<!--
1. All dropdown data is cached in the browser for performance
2. Consider using a global state management solution for large applications
3. Dropdown options are returned in alphabetical order (automatically sorted by name)
4. Only active dropdown options (is_active: true) are returned in API responses
5. Use the ID field for filtering/querying, not the slugs
6. To add new categories/sleeve types/collection types:
   - Admin goes to: /admin/categories, /admin/sleeve-types, /admin/collection-types
   - Admin creates new entries
   - Frontend immediately sees them via API (no code changes needed!)

EXAMPLE UPDATE FLOW:
1. Admin creates new category "Jackets" via /admin/categories/create
2. Category is saved to database with is_active = true
3. Frontend calls /api/dropdowns/categories
4. "Jackets" appears in the dropdown automatically
5. Users can filter by "Jackets" right away
-->
