<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Thums Up 750ml - Product Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="dist/output.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
</head>
<body class="bg-white text-gray-800">

  <div class="max-w-6xl mx-auto py-10 px-4 grid grid-cols-1 md:grid-cols-3 gap-10">
    <!-- Left: Thumbnails and Main Image -->
    <div class="md:col-span-1">
      <div class="space-y-4">
        <img src="image/thumsup750.png" class="border p-2 w-24 h-24 object-contain cursor-pointer" alt="Thumbs up thumb 1">
        <img src="image/thumsup-back.png" class="border p-2 w-24 h-24 object-contain cursor-pointer" alt="Thumbs up thumb 2">
        <img src="image/thumsup-nutrition.png" class="border p-2 w-24 h-24 object-contain cursor-pointer" alt="Nutrition info">
        <img src="image/thumsup-ingredients.png" class="border p-2 w-24 h-24 object-contain cursor-pointer" alt="Ingredients">
      </div>
    </div>

    <!-- Center: Main Product Image -->
    <div class="md:col-span-1 flex items-center justify-center">
      <img id="mainImage" src="image/thumsup750.png" class="w-full max-w-sm object-contain" alt="Thums Up Bottle">
    </div>

    <!-- Right: Product Info -->
    <div class="md:col-span-1 space-y-6">
      <div>
        <h2 class="text-xl font-semibold">Thums Up</h2>
        <h1 class="text-3xl font-bold">Thums Up 750 ml</h1>
        <div class="flex items-center space-x-2 text-yellow-500 mt-2">
          <span>★★★★☆</span><span class="text-gray-600 text-sm">73340 reviews</span>
        </div>
      </div>

      <div>
        <p class="text-2xl text-red-600 font-bold">
          ₹39.00 <span class="text-green-600 text-sm ml-2 bg-green-100 px-2 py-1 rounded">13% Off</span>
        </p>
        <p class="text-gray-600 text-sm mt-1">M.R.P: <s>₹45.00</s> (Incl. of all taxes)</p>
      </div>

      <div>
        <h3 class="font-semibold mb-1">Packsize</h3>
        <div class="flex items-center border rounded p-3 justify-between">
          <div class="flex items-center space-x-3">
            <img src="image/thumsup750.png" class="w-10 h-10 object-contain" alt="Pack image">
            <p>Pack of 1</p>
          </div>
          <div class="text-right">
            <p class="text-lg font-semibold">₹39.00</p>
            <p class="text-sm text-green-600">13% OFF</p>
          </div>
        </div>
      </div>

      <div>
        <h3 class="font-semibold mb-1">Size</h3>
        <div class="border rounded p-3 flex justify-between items-center opacity-50 cursor-not-allowed">
          <div class="flex items-center space-x-3">
            <img src="image/thumsup2l.png" class="w-10 h-10 object-contain" alt="2L Bottle">
            <p>2 L</p>
          </div>
          <span class="text-red-600 font-semibold">Out of stock</span>
        </div>
      </div>

      <button onclick="addToCart(product)" class="bg-red-600 hover:bg-red-700 text-white w-full py-3 font-bold rounded">
        Add to Cart
      </button>
    </div>
  </div>

  <!-- Bottom Full Width Size Selector -->
  <div class="w-full bg-gray-50 border-t py-8 px-4">
    <h3 class="text-xl font-bold mb-4">Available Sizes</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-6xl mx-auto">
      <div class="border rounded p-4 flex justify-between items-center cursor-not-allowed opacity-50">
        <div class="flex items-center space-x-3">
          <img src="image/thumsup180.png" class="w-10 h-10 object-contain" alt="180ml">
          <p>180 ml</p>
        </div>
        <span class="text-red-600 font-semibold">Out of stock</span>
      </div>
      <div class="border rounded p-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
          <img src="image/thumsup250.png" class="w-10 h-10 object-contain" alt="250ml">
          <p>250 ml</p>
        </div>
        <div class="text-right">
          <p class="text-lg font-semibold">₹19.00</p>
          <p class="text-sm text-green-600">5% OFF</p>
        </div>
      </div>
      <div class="border rounded p-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
          <img src="image/thumsup300.png" class="w-10 h-10 object-contain" alt="300ml">
          <p>300 ml</p>
        </div>
        <div class="text-right">
          <p class="text-lg font-semibold">₹36.00</p>
          <p class="text-sm text-green-600">10% OFF</p>
        </div>
      </div>
      <div class="border border-blue-500 rounded p-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
          <img src="image/thumsup750.png" class="w-10 h-10 object-contain" alt="750ml">
          <p class="font-bold">750 ml</p>
        </div>
        <div class="text-right">
          <p class="text-lg font-semibold">₹39.00</p>
          <p class="text-sm text-green-600">13% OFF</p>
        </div>
      </div>
      <div class="border rounded p-4 flex justify-between items-center cursor-not-allowed opacity-50">
        <div class="flex items-center space-x-3">
          <img src="image/thumsup1750.png" class="w-10 h-10 object-contain" alt="1.75L">
          <p>1.75 L</p>
        </div>
        <span class="text-red-600 font-semibold">Out of stock</span>
      </div>
      <div class="border rounded p-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
          <img src="image/thumsup2250.png" class="w-10 h-10 object-contain" alt="2.25L">
          <p>2.25 L</p>
        </div>
        <div class="text-right">
          <p class="text-lg font-semibold">₹85.00</p>
          <p class="text-sm text-green-600">15% OFF</p>
        </div>
      </div>
      <div class="border rounded p-4 flex justify-between items-center cursor-not-allowed opacity-50">
        <div class="flex items-center space-x-3">
          <img src="image/thumsup1250.png" class="w-10 h-10 object-contain" alt="1.25L">
          <p>1.25 L</p>
        </div>
        <span class="text-red-600 font-semibold">Out of stock</span>
      </div>
    </div>
  </div>

  <script>
    const product = {
      id: 101,
      name: "Thums Up 750 ml",
      price: 39,
      image: "image/thumsup750.png",
      quantity: 1
    };

    function addToCart(item) {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      const existing = cart.find(p => p.id === item.id);

      if (existing) {
        existing.quantity++;
      } else {
        cart.push(item);
      }

      localStorage.setItem("cart", JSON.stringify(cart));
      toastr.success(item.name + " added to cart!");
    }
  </script>

</body>
</html>