<!DOCTYPE html>
<html>
<head>
    <title>Sell Item</title>
</head>

    <style>
 .navbar-vertical {
        width: 100%;
        background: #222;
        padding: 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
    .block-vertical {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .navbar-brand-vertical {
        margin: 20px 0 10px 0;
    }
    .logo-vertical {
        height: 80px;
    }
    .navbar-nav-vertical {
        list-style: none;
        padding: 0;
        margin: 0;
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        border-top: 1px solid #333;
    }
    .nav-item-vertical {
        margin: 0 20px;
    }
    .nav-link-vertical {
        display: block;
        color: #fff;
        text-decoration: none;
        padding: 18px 0;
        font-size: 18px;
        transition: color 0.2s;
    }
    .nav-link-vertical.active,
    .nav-link-vertical:hover {
        color: #ffd700;
    }
  .cart-count {
            position: relative;
            color:white;
            color:white; 
            text-decoration:none;"
        }
        .cart-count span {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 50%;
        }
     @media (max-width: 768px) {
.navbar-nav-vertical {
    flex-direction: row;
    gap: 18px;
}
.container-vertical {
    flex-direction: row;
    align-items: center;
    width: 100vw;
}
.logo-vertical {
    height: 40px;
}
     }
/* FORM SECTION */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f6f8fa;
    margin: 0;
    padding: 0;
}

h1, h2 {
    text-align: center;
    color: #222;
}

label {
    font-weight: 600;
    color: #333;
}

input[type="text"],
input[type="number"],
select,
textarea {
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 10px;
    font-size: 15px;
    background-color: #fff;
    transition: border 0.3s ease;
}

input[type="text"]:focus,
input[type="number"]:focus,
select:focus,
textarea:focus {
    border-color: #4a90e2;
    outline: none;
}

input[type="file"] {
    margin-top: 10px;
}

.btn {
    background-color: #4a90e2;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 12px 18px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    transition: background 0.3s ease;
}

.btn:hover {
    background-color: #3d7cd4;
}

.add-photo-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: bold;
    cursor: pointer;
    margin-bottom: 10px;
}

/* CONTAINER FLEX */
.container-flex {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 40px;
    padding: 30px;
}

.form-block,
.preview-block {
    padding: 24px;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 3px 12px rgba(0,0,0,0.05);
    max-width: 400px;
    flex: 1;
}

.preview-block {
    min-width: 300px;
}

.preview-block h3 {
    margin-top: 10px;
    color: #333;
}

.preview-block p {
    margin: 6px 0;
    color: #555;
}

#previewImage {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
}



</style>
<body>
      <nav id="header" class="navbar-vertical">
        <div class="container-vertical">
            <a href="#" class="navbar-brand-vertical">
                <img src="img/logo.png" class="logo-vertical" alt="Logo">
            </a>
            <ul class="navbar-nav-vertical">
                <li class="nav-item-vertical"><a class="nav-link-vertical" href="homepage.php">Home</a></li>
                <li class="nav-item-vertical"><a class="nav-link-vertical" href="shop.php">Shop</a></li>
                <li class="nav-item-vertical"><a class="nav-link-vertical active" href="sell.php">Sell</a></li>
                <li class="nav-item-vertical"><a class="nav-link-vertical" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item-vertical" id="lg-bag-vertical"><a class="nav-link-vertical" href="cart.html"><i class="far fa-shopping-bag"></i></a></li>
            <li class="cart-count" style="color:white;">
    <a href="cart.php" style="color:white; text-decoration:none;">
        🛒 <i class="fas fa-shopping-cart"></i>
        <span><?php echo isset($cartCount) ? $cartCount : 0; ?></span>
    </a>
</li>
            </ul>
        </div>
    </nav>
      <div class="container-flex" id="listItem">
         <div class="form-block">
            <form method="POST" action="itemslist.php" enctype="multipart/form-data" id="sellForm">

               <!-- STEP 1 -->
<div id="basicFormSection">
    <label class="add-photo-label">
        <span style="font-size: 22px;">🖼️</span> Add photos
    </label>
    <input type="file" name="image" accept="image/*" required><br><br>

    <label>Title:</label><br>
    <input type="text" name="name" required style="width: 100%;"><br><br>

    <label>Category:</label><br>
    <select name="category" required style="width: 100%;">
        <option value="Electronics">⚡Electronics</option>
        <option value="Books/Stationery">📚Books/Stationery</option>
        <option value="Furniture">🛋️Furniture</option>
        <option value="Thrift">👗Thrift</option>
    </select><br><br>

    <label>Price (R):</label><br>
    <input type="number" step="0.01" name="price" required style="width: 100%;"><br><br>

    <label>Condition:</label><br>
    <select name="condition" required style="width: 100%;">
        <option value="New">New</option>
        <option value="Used - Like New">Used - Like New</option>
        <option value="Used - Good">Used - Good</option>
        <option value="Used - Fair">Used - Fair</option>
    </select><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="4" style="width: 100%;" required></textarea><br><br>

    <label>Pick-up Address:</label><br>
    <textarea name="pickup_address" rows="3" style="width: 100%;" required></textarea><br><br>

    <button type="button" class="btn" onclick="goToStep2()">Next</button>
</div>

<!-- STEP 2: Additional Fields -->
<div id="additionalFormSection" style="display:none;">
    <h3>Additional Product Details (Optional)</h3>

    <label>Categories Path:</label><br>
    <input type="text" name="category_path"><br><br>

    <label>Brand:</label><br>
    <input type="text" name="brand"><br><br>

    <label>Power:</label><br>
    <input type="text" name="power"><br><br>

    <label>Warranty:</label><br>
    <input type="text" name="warranty"><br><br>

    <label>Non-Stick:</label><br>
    <select name="non_stick">
        <option value="">-- Select --</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select><br><br>

    <label>Model:</label><br>
    <input type="text" name="model"><br><br>

    <label>What's in the box:</label><br>
    <textarea name="whats_in_box"></textarea><br><br>

    <label>Dishwasher Safe:</label><br>
    <select name="dishwasher_safe">
        <option value="">-- Select --</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select><br><br>

    <label>Appliance Type:</label><br>
    <input type="text" name="appliance_type"><br><br>

    <label>Barcode:</label><br>
    <input type="text" name="barcode"><br><br>

    <div style="display: flex; gap: 10px;">
        <button type="button" class="btn" onclick="goBackToStep1()">Back</button>
        <input type="submit" class="btn" value="List Item" name="listItem">
    </div>
</div>


            </form>
</div>
        <div class="preview-block" id="previewBlock">
            <h2>Preview</h2>
            <div id="previewImage" style="width:100%;height:180px;background:#eee;display:flex;align-items:center;justify-content:center;">
                <span style="color:#bbb;">Image Preview</span>
            </div>
            <h3 id="previewTitle">Title</h3>
            <p><strong>Price:</strong> <span id="previewPrice">R 0.00</span></p>
            <p><strong>Category:</strong> <span id="previewCategory">Select Category</span></p>
            <p><strong>Condition:</strong> <span id="previewCondition">New</span></p>
            <p><strong>Seller:</strong> <?php 
       if(isset($_SESSION['email'])){
        $email=$_SESSION['email'];
        $query=mysqli_query($conn, "SELECT users.* FROM users WHERE users.email='$email'");
        while($row=mysqli_fetch_array($query)){
            echo $row['firstName'] . ' ' . $row['lastName'];
        
       }
    }
       ?></p>
            <p id="previewDescription"></p>
        </div>
    </div>
    <script>
    const nameInput = document.querySelector('input[name="name"]');
    const priceInput = document.querySelector('input[name="price"]');
    const conditionInput = document.querySelector('select[name="condition"]');
    const descInput = document.querySelector('textarea[name="description"]');
    const imageInput = document.querySelector('input[name="image"]');
      
            // Update preview when category changes
            document.querySelectorAll('input[name="category"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    document.getElementById('previewCategory').textContent = this.value;
                });
            });
        

    // Listen for category button clicks
    document.querySelectorAll('button[name="category"]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            selectedCategory = this.value;
            setTimeout(updatePreview, 10); // update after form submit
        });
    });

    function updatePreview() {
        document.getElementById('previewTitle').textContent = nameInput.value || 'Title';
        document.getElementById('previewPrice').textContent = priceInput.value ? 'R ' + priceInput.value : 'R 0.00';
        document.getElementById('previewCategory').textContent = categoryButtons || 'Select Category';
        document.getElementById('previewCondition').textContent = conditionInput.value;
        document.getElementById('previewDescription').textContent = descInput.value;
    }
    [nameInput, priceInput, conditionInput, descInput].forEach(input => {
        input.addEventListener('input', updatePreview);
    });
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').innerHTML = '<img src="' + e.target.result + '" style="max-width:100%;max-height:180px;">';
            };
            reader.readAsDataURL(file);
        }
    });


    </script>
    <script src="script.js"></script>
   
<script>
function goToStep2() {
    document.getElementById('basicFormSection').style.display = 'none';
    document.getElementById('additionalFormSection').style.display = 'block';
}
</script>
<script>
function goToStep2() {
    document.getElementById('basicFormSection').style.display = 'none';
    document.getElementById('additionalFormSection').style.display = 'block';
}

function goBackToStep1() {
    document.getElementById('additionalFormSection').style.display = 'none';
    document.getElementById('basicFormSection').style.display = 'block';
}
</script>


</body>
</html>

