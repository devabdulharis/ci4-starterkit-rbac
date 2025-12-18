<!DOCTYPE html>
<html data-theme="emerald" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CI4 Starter</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-base-200 flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-primary/20 rounded-full blur-3xl"></div>
    <div class="absolute top-20 right-20 w-72 h-72 bg-secondary/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-20 left-1/2 w-80 h-80 bg-accent/10 rounded-full blur-3xl"></div>

    <div class="card w-full max-w-sm bg-base-100/80 backdrop-blur-md shadow-2xl border border-base-200">
        <form action="/reset-password/update" method="post" class="card-body">
            <?= csrf_field() ?>
            <input type="hidden" name="token" value="<?= esc($token) ?>">
            <input type="hidden" name="email" value="<?= esc($email) ?>">
            
            <div class="text-center mb-2">
                <h2 class="text-2xl font-bold">Reset Password</h2>
                <p class="text-base-content/60 text-sm">Create a new password</p>
            </div>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div role="alert" class="alert alert-error mb-4 text-sm py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">New Password</span>
                </label>
                <div class="relative">
                    <input type="password" name="password" class="input input-bordered w-full pl-10 focus:input-primary transition-all" placeholder="••••••••" required />
                    <span class="absolute left-3 top-3.5 text-base-content/40">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70"><path fill-rule="evenodd" d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z" clip-rule="evenodd" /></svg>
                    </span>
                 </div>
            </div>

            <div class="form-control mt-4">
                <label class="label">
                    <span class="label-text">Confirm Password</span>
                </label>
                <div class="relative">
                    <input type="password" name="confpassword" class="input input-bordered w-full pl-10 focus:input-primary transition-all" placeholder="••••••••" required />
                    <span class="absolute left-3 top-3.5 text-base-content/40">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70"><path fill-rule="evenodd" d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z" clip-rule="evenodd" /></svg>
                    </span>
                 </div>
            </div>
            
            <div class="form-control mt-6">
                <button class="btn btn-primary w-full shadow-lg">Reset Password</button>
            </div>
        </form>
    </div>
</body>
</html>