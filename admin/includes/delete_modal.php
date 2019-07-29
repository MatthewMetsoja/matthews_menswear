<!-- Modal -->
<div class="modal fade"  id="delete_product_modal" tabindex="-1" data-backdrop="static" data-keyboard="false"  role="dialog" aria-labelledby="delete_product_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                  Are you sure you want to delete "<span id="modal_span_id"> </span> " from <span id="modal_span_title_cat"> </span>
              </h5>
             
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>

          <h6> If so then please confirm master password and press delete</h6>
         
          <div class="modal-body"> 
              <div class="row"> 
                  <div class="col-6"> <br><br><br><br>
          <form action="" method="post">
                      <label for="">Master Password </label>
                      <input class="form-control" name="pass" type="password"> <br>
            
                      <label for="">Confirm Password </label>
                      <input class="form-control" name="pass_con" type="password">
                
                      <!-- hidden input so we can pass the id  with js for the delete query  -->
                      <input type="hidden" name="id" id="id_to_send" value="">
                  </div>
                
                  <div class="col-6">
                      <img id="modal_delete_product_pic" class="img-fluid" src="" alt=""> 
                  </div>

              </div>
          </div>

          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" name="delete_submit" class="btn btn-danger">Delete item</button>
          </form>  
          </div>
        </div>
    </div>
</div>


</div>  
</div>
</div> 
<div class="col-sm-1"> </div>  
     <br>
</div>
</div>