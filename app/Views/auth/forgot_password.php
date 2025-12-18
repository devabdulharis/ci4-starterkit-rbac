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
        <form action="/forgot-password" method="post" class="card-body">
            <?= csrf_field() ?>
            
            <div class="text-center mb-2">
                <h2 class="text-2xl font-bold">Forgot Password</h2>
                <p class="text-base-content/60 text-sm">Enter your email to receive reset link</p>
            </div>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div role="alert" class="alert alert-error mb-4 text-sm py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('message')): ?>
                <div role="alert" class="alert alert-success mb-4 text-sm py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span><?= session()->getFlashdata('message') ?></span>
                </div>
            <?php endif; ?>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <div class="relative">
                    <input type="email" name="email" class="input input-bordered w-full pl-10 focus:input-primary transition-all" placeholder="admin@example.com" required value="<?= old('email') ?>" />
                    <span class="absolute left-3 top-3.5 text-base-content/40">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                          <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                          <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                        </svg>
                    </span>
                 </div>
            </div>
            
            <div class="form-control mt-6">
                <button class="btn btn-primary w-full shadow-lg">Send Reset Link</button>
            </div>

            <div class="text-center mt-4">
                <a href="/login" class="link link-hover text-sm">Back to Login</a>
            </div>
        </form>
    </div>
</body>
</html>