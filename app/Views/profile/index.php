<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="flex items-center gap-4 mb-6">
    <h1 class="text-2xl font-bold">My Profile</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Profile Card -->
    <div class="lg:col-span-1">
        <div class="card bg-base-100 shadow-xl border border-base-200">
            <div class="card-body items-center text-center">
                <div class="avatar placeholder mb-4">
                    <div class="bg-primary text-primary-content rounded-full w-24 text-3xl">
                        <span><?= strtoupper(substr($user['name'], 0, 2)) ?></span>
                    </div>
                </div>
                <h2 class="card-title"><?= esc($user['name']) ?></h2>
                <p class="text-base-content/60"><?= esc($user['email']) ?></p>
                <div class="flex flex-wrap gap-2 justify-center mt-4">
                    <?php 
                        $roles = (new \App\Models\UserModel())->getRoles($user['id']);
                        foreach($roles as $role):
                    ?>
                        <span class="badge badge-outline"><?= esc($role['name']) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="lg:col-span-2">
        <form action="/profile/update" method="post" class="card bg-base-100 shadow-xl border border-base-200">
            <div class="card-body">
                <h3 class="card-title mb-4">Edit Profile Info</h3>
                <?= csrf_field() ?>
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Name -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Full Name</span>
                        </label>
                        <input type="text" name="name" class="input input-bordered focus:input-primary transition-all" required value="<?= old('name', $user['name']) ?>" />
                    </div>

                    <!-- Email -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Email Address</span>
                        </label>
                        <input type="email" name="email" class="input input-bordered focus:input-primary transition-all" required value="<?= old('email', $user['email']) ?>" />
                    </div>

                    <!-- Password -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">New Password</span>
                        </label>
                        <input type="password" name="password" class="input input-bordered focus:input-primary transition-all" placeholder="••••••••" />
                        <label class="label">
                            <span class="label-text-alt text-base-content/60">Leave blank to keep current password</span>
                        </label>
                    </div>
                </div>

                <div class="card-actions justify-end mt-8 pt-6 border-t border-base-200">
                    <button type="submit" class="btn btn-primary px-8">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
