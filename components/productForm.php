<form method="POST" class="card p-4 shadow-sm" action="<?= $formAction ?? '' ?>">

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>

        <input type="text" class="form-control 
        <?php echo $v->get_error_message('title') ? 'is-invalid' : ''; ?>" id="title" name="title"
            value="<?php echo htmlspecialchars($product->title ?? ''); ?>">

        <span class="invalid-feedback d-block">
            <?php echo $v->get_error_message('title'); ?>
        </span>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>

        <textarea class="form-control" id="description" name="description" rows="4">
            <?php echo htmlspecialchars($product->description ?? ''); ?>
        </textarea>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control 
        <?php echo $v->get_error_message('price') ? 'is-invalid' : ''; ?>" id="price" name="price"
            value="<?php echo htmlspecialchars($product->price ?? ''); ?>">

        <span class="invalid-feedback d-block">
            <?php echo $v->get_error_message('price'); ?></span>
    </div>

    <div class="mb-4">
        <label for="stock_quantity" class="form-label">Stock Level</label>
        <input type="number" class="form-control 
        <?php echo $v->get_error_message('stock_quantity') ? 'is-invalid' : ''; ?>" id="stock_quantity"
            name="stock_quantity" value="<?php echo htmlspecialchars($product->stock_quantity ?? ''); ?>">
        <span class="invalid-feedback d-block">
            <?php echo $v->get_error_message('stock_quantity'); ?>
        </span>
    </div>

    <div class="mb-4">
        <label for="category_id" class="form-label">Category</label>
        <select name="category_id" id="category_id"
            class="form-select <?php echo $v->get_error_message('category_id') ? 'is-invalid' : ''; ?>">
            <option value="">Choose category</option>
            <?php foreach ($allCategories as $category): ?>
                <option value="<?= $category->id ?>" <?= ((string) ($product->category_id ?? '') === (string) $category->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category->category_name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span class="invalid-feedback d-block">
            <?php echo $v->get_error_message('category_id'); ?>
        </span>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <?= $buttonText ?? 'Save' ?>
        </button>

        <a href="/admin" class="btn btn-outline-secondary">Cancel
        </a>
    </div>
</form>