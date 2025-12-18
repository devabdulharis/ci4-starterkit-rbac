<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex items-center gap-4 mb-6">
    <a href="/roles" class="btn btn-circle btn-ghost btn-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
    </a>
    <h1 class="text-2xl font-bold">Edit Role</h1>
</div>

<div class="max-w-4xl mx-auto">
    <form action="/roles/update/<?= $role['id'] ?>" method="post" class="card bg-base-100 shadow-xl border border-base-200">
        <div class="card-body">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 gap-6">
                <!-- Name -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Role Name</span>
                    </label>
                    <input type="text" name="name" class="input input-bordered focus:input-primary transition-all" required value="<?= old('name', $role['name']) ?>" />
                </div>

                <!-- Description -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Description</span>
                    </label>
                    <textarea name="description" class="textarea textarea-bordered h-24 focus:textarea-primary transition-all"><?= old('description', $role['description']) ?></textarea>
                </div>
            </div>

            <div class="card-actions justify-end mt-8 pt-6 border-t border-base-200">
                <a href="/roles" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary px-8">Save Changes</button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
