<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['dark' => ($appearance ?? 'system') == 'dark']); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('apple-touch-icon.png')); ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('favicon-32x32.png')); ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('favicon-16x16.png')); ?>">
<link rel="manifest" href="<?php echo e(asset('site.webmanifest')); ?>">
<link rel="mask-icon" href="<?php echo e(asset('safari-pinned-tab.svg')); ?>" color="#5bbad5"> 
<meta name="msapplication-TileColor" content="#da532c"> 
<meta name="theme-color" content="#ffffff"> 
<link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">


        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <title>Radar LEB</title>

        <?php echo app('Tighten\Ziggy\BladeRouteGenerator')->generate(); ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.ts']); ?>
        <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->head; } ?>
    </head>
    <body class="font-sans antialiased">
        <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->body; } else { ?><div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div><?php } ?>
    </body>
</html><?php /**PATH C:\Users\rayan\Desktop\Radarleb coding\resources\views/app.blade.php ENDPATH**/ ?>