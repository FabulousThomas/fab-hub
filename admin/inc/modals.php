<style>
    label {
        margin-bottom: 0;
    }

    .modal input {
        background-color: transparent;
    }
</style>

<!-- == Modal == -->
<div class="modal fade" id="edit-product-modal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header py-2 bg-light">
                <h5 class="modal-title">Edit Products</h5>
                <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <form method="POST" id="form" enctype="multipart/form-data">

                    <input type="hidden" name="product_id" id="product_id" value="" class="form-control"
                        placeholder="Product Id">
                    <div class="form-group mb-0 mb-lg-3 row">
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Product Name</label>
                            <input type="text" name="product_name" id="product_name" value="" class="form-control"
                                placeholder="Product Name">
                        </div>
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Product Price</label>
                            <input type="text" name="product_price" id="product_price" value="" class="form-control"
                                placeholder="Product Price">
                        </div>
                    </div>
                    <div class="form-group mb-0 mb-lg-3 row">
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Product Color</label>
                            <input type="text" name="product_color" id="product_color" value="" class="form-control"
                                placeholder="Product Color">
                        </div>
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Product Offer</label>
                            <input type="text" name="product_special_offer" id="product_special_offer" value=""
                                class="form-control" placeholder="Product Offer">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Product Category</label>
                        <select class="custom-select form-control" name="product_category" id="product_category">
                            <option selected disabled>Product Category</option>
                            <?php
                            $result = getDistinct("product_category", "products");
                            ?>
                            <?php foreach ($result as $row): ?>
                                <option value="<?= $row['product_category'] ?>">
                                    <?= $row['product_category'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Product Description</label>
                        <textarea name="product_description" id="product_description" class="form-control"
                            placeholder="Product Description" rows="4"></textarea>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="submit" class="btn-orange btn-sm" name="btn-update-product">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- == EDIT ORDERS == -->
<div class="modal fade" id="edit-order-modal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header py-2 bg-light">
                <h5 class="modal-title">Edit Orders</h5>
                <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" value="">
                    <div class="form-group mb-0 mb-lg-3 row">
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <input type="hidden" name="order_id" id="order_id" value="" class="form-control"
                                placeholder="order Id">
                            <label for="">Order Cost</label>
                            <input type="text" name="order_cost" id="order_cost" value="" class="form-control"
                                placeholder="order Cost">
                        </div>
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Order Status</label>
                            <select class="custom-select form-control" name="order_status" id="order_status">
                                <option selected disabled>Order Status</option>
                                <?php $orders = getDistinct("order_status", "Orders"); ?>
                                <?php if ($orders): ?>
                                    <?php foreach ($orders as $order): ?>
                                        <option value="<?= $order['order_status'] ?>">
                                            <?= $order['order_status'] ?>
                                        </option>
                                    <?php endforeach; ?>

                                    <?php if (isset($order['order_status']) && $order['order_status'] != "shipped"): ?>
                                        <option value="shipped">shipped</option>
                                    <?php endif; ?>
                                    <?php if (isset($order['order_status']) && $order['order_status'] == "delivered"): ?>
                                        <option value="delivered">delivered</option>
                                    <?php endif; ?>
                                    <?php if (isset($order['order_status']) && $order['order_status'] == "paid"): ?>
                                        <option value="paid">paid</option>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-0 mb-lg-3 row">
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">User Id</label>
                            <input type="text" name="user_id" id="user_id" value="" class="form-control" disabled
                                placeholder="user Id">
                        </div>
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Order Date</label>
                            <input type="text" name="order_date" id="order_date" value="" class="form-control" disabled
                                placeholder="order Date">
                        </div>
                    </div>

                    <div class="form-group mb-0 mb-lg-3 row">
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">User Phone</label>
                            <input type="text" name="user_phone" id="user_phone" value="" class="form-control" disabled
                                placeholder="User Phone">
                        </div>
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">User Email</label>
                            <input type="text" name="user_email" id="user_email" value="" class="form-control" disabled
                                placeholder="User Email">
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="submit" class="btn-orange btn-sm" name="btn-update-orders">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- == ADD PRODUCTS == -->
<div class="modal fade" id="add-product-modal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header py-2 bg-light">
                <h5 class="modal-title">Add New Products</h5>
                <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" value="">
                    <div class="form-group mb-0 mb-lg-3 row">
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Product Name</label>
                            <input type="text" name="product_name" id="product_name" value="" class="form-control"
                                placeholder="Product Name">
                        </div>

                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Product Category</label>
                            <input type="text" name="product_category" id="product_category" value=""
                                class="form-control" placeholder="shoes, bags, coats, headphones, clothes">
                        </div>
                    </div>

                    <div class="form-group mb-0 mb-lg-3 row">
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Product Price</label>
                            <input type="text" name="product_price" id="product_price" value="" class="form-control"
                                placeholder="Product Price">
                        </div>
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Product Offer</label>
                            <input type="text" name="product_offer" id="product_offer" value="" class="form-control"
                                placeholder="Product Offer (0, 10, 20)">
                        </div>
                    </div>

                    <div class="form-group mb-0 mb-lg-3 row">
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Product Color</label>
                            <input type="text" name="product_color" id="product_color" value="" class="form-control"
                                placeholder="Product Color">
                        </div>
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Product Tag</label>
                            <input type="text" name="product_tag" id="product_tag" value="" class="form-control"
                                placeholder="fashion, electronics, accessories">
                        </div>
                    </div>

                    <div class="form-group mb-0 mb-lg-3 row">
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Product Image 1</label>
                            <input type="file" name="product_image1" id="product_image1" value="" class="form-control"
                                placeholder="Product Image 1">
                        </div>
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Product Image 2</label>
                            <input type="file" name="product_image2" id="product_image2" value="" class="form-control"
                                placeholder="Product Image 2">
                        </div>
                    </div>

                    <div class="form-group mb-0 mb-lg-3 row">
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Product Image 3</label>
                            <input type="file" name="product_image3" id="product_image3" value="" class="form-control"
                                placeholder="Product Image 3">
                        </div>
                        <div class="col-md-6 mb-3 mb-lg-0">
                            <label for="">Product Image 4</label>
                            <input type="file" name="product_image4" id="product_image4" value="" class="form-control"
                                placeholder="Product Image 4">
                        </div>
                    </div>

                    <div class="form-group mb-0 mb-lg-3">

                        <label for="">Product Description</label>
                        <textarea name="product_description" id="product_description" rows="3" class="form-control"
                            placeholder="Details about this product"></textarea>
                    </div>

                    <div class="modal-footer py-2">
                        <button type="submit" class="btn-orange btn-sm" name="btn-add-product"><i
                                class="las la-plus"></i> Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- == EDIT PRODUCT IMAGE == -->
<div class="modal fade" id="edit-product-image-modal" tabindex="-1" role="dialog" data-backdrop="static"
    aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header py-2 bg-light">
                <h5 class="modal-title">Update Product Image</h5>
                <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">


                <form method="POST" enctype="multipart/form-data">
                    <?php
                    $product_img = getAllById('products', 'product_id');
                    ?>
                    <?php foreach ($product_img as $row): ?>
                        <div class="form-group mb-0 mb-lg-3 row">
                            <div class="col-md-6 mb-3 mb-lg-0">
                                <input type="text" name="product_name" id="product_img_name"
                                    value="<?= $row['product_name'] ?>" class="form-control" placeholder="Product Name">
                            </div>
                            <div class="col-md-6 mb-3 mb-lg-0">
                                <input type="text" name="product_id" id="product_img_id" value="<?= $row['product_id'] ?>"
                                    class="form-control" placeholder="Product Id">
                            </div>
                        </div>


                        <div class="form-group mb-0 mb-lg-3 row">
                            <div class="col-md-6 mb-3 mb-lg-0">
                                <label for="">Product Image 1</label>
                                <input type="text" name="product_image1" id="product_img_image1" value="" class="form-control"
                                    placeholder="Product Image 1">
                                <input type="hidden" name="old_image" value="<?= $row['product_image'] ?>">
                                <label for="image" class="m-0">Current Image: </label>
                                <img src="../assets/img/<?= $row['product_image'] ?>" id="product_img_image1" width="40px" height="40px" alt="">
                            </div>
                            <div class="col-md-6 mb-3 mb-lg-0">
                                <label for="">Product Image 2</label>
                                <input type="text" name="product_image2" id="product_img_image2" value=""
                                    class="form-control" placeholder="Product Image 2">
                            </div>
                        </div>

                        <div class="form-group mb-0 mb-lg-3 row">
                            <div class="col-md-6 mb-3 mb-lg-0">
                                <label for="">Product Image 3</label>
                                <input type="text" name="product_image3" id="product_img_image3" value=""
                                    class="form-control" placeholder="Product Image 3">
                            </div>
                            <div class="col-md-6 mb-3 mb-lg-0">
                                <label for="">Product Image 4</label>
                                <input type="text" name="product_image4" id="product_img_image4" value=""
                                    class="form-control" placeholder="Product Image 4">
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="modal-footer py-2">
                        <button type="submit" class="btn-orange btn-sm" name="btn-update-product-image">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>