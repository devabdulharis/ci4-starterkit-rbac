<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex items-center gap-4 mb-6">
    <a href="/users" class="btn btn-circle btn-ghost btn-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold">Assign Roles: <span class="text-primary"><?= esc($user['name']) ?></span></h1>
        <p class="text-base-content/60 text-sm">Select effective roles for this user</p>
    </div>
</div>

<div class="max-w-4xl mx-auto">
    <form action="/users/roles/update/<?= $user['id'] ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="card bg-base-100 shadow-xl border border-base-200">
            <div class="card-body">
                <div class="space-y-4">
                    <?php foreach ($roles as $role): ?>
                    <div class="form-control">
                         <label class="label cursor-pointer justify-start gap-4 p-4 border rounded-xl hover:bg-base-200/50 hover:border-primary/50 transition-all <?= in_array($role['id'], $userRoles) ? 'bg-primary/5 border-primary' : 'border-base-200' ?>">
                            <input type="checkbox" name="roles[]" value="<?= $role['id'] ?>" 
                                class="checkbox checkbox-primary"
                                <?= in_array($role['id'], $userRoles) ? 'checked' : '' ?> />
                            <div class="flex flex-col">
                                <span class="font-bold text-lg"><?= esc($role['name']) ?></span>
                                <span class="text-sm text-base-content/60"><?= esc($role['description']) ?></span>
                            </div>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="card-actions justify-end mt-8 pt-6 border-t border-base-200">
                    <a href="/users" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary px-8">Save Roles</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
