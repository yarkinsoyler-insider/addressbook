<!-- resources/views/welcome.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Vue Sanctum</title>
</head>

<body>
    <div id="app">
        <!-- Vue bileşenimizi burada yükleyeceğiz -->
        <app></app>
    </div>

    <!-- Laravel Mix tarafından oluşturulan JavaScript dosyasını ekleyin -->
    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>