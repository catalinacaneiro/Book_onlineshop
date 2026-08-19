<form method="POST" class="card p-4 shadow-sm" action="<?= $formAction ?? '' ?>">

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>

        <input
            type="email"
            class="form-control <?= $v->get_error_message('email') ? 'is-invalid' : '' ?>"
            id="email"
            name="email"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
        >

        <span class="invalid-feedback d-block">
            <?= $v->get_error_message('email') ?>
        </span>
    </div>


    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>

        <input
            type="password"
            class="form-control <?= $v->get_error_message('password') ? 'is-invalid' : '' ?>"
            id="password"
            name="password"
        >

        <span class="invalid-feedback d-block">
            <?= $v->get_error_message('password') ?>
        </span>
    </div>


  
    <!-- Button -->
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <?= $buttonText ?? 'Login' ?>
        </button>
    </div>

</form>