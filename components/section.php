<section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    
                    <?php 
                    /*--- Visar 10 mest populära produkter i startsidan--- */
                    foreach($popularProduct as $product){
                    ?> 
                    
                    <div class="col mb-5 book-column">
                        <div class="card h-100 book-card">
                            <!-- Product image-->
                            <img class="card-img-top book-img" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body book-body">
                                <div class="text-center">
                                    <!-- Product name-->
                                     <a class="text-dark text-decoration-none" href="/product?id=<?php echo $product->id ?>">
                                    <h5 class="rubrik"><?php echo htmlspecialchars($product->title); ?></h5>
                                    <!-- Product rating -->
                                     <?php echo htmlspecialchars($product->description); ?>
                                    </a>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer book-footer">
                                <div class="text-center"><a class="book-btn" href="/product?id=<?php echo (int)$product->id; ?>">Product Details</a></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div> 
</section>