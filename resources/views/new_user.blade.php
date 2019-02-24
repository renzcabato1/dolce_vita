<div class="modal fade" id="new_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='row w-100'>
                    <div class='col-10'>
                        <h1 class="modal-title" id="exampleModalLabel">New User</h1>
                    </div>
                    <div class='col-2'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                </div>
            </div>
            <form  method='POST' action='new-user'  onsubmit="show()" >
                <div class="modal-body"> 
                    <div class='row w-100'>
                        {{ csrf_field() }}
                        <div class='col-md-12'>
                            <div class="form-group">
                                <label>Name:</label>
                                <input class="form-control" pattern="[A-Za-z ,.]+" type="text" name='name' id='name' placeholder='Name..'  required>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100'>
                        <div class='col-md-12'>
                            <div class="form-group">
                                <label>Email:</label>
                                <input class="form-control" type="email" name='email'  id='email' placeholder='Email@email.com' required>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100'>
                        <div class='col-md-12'>
                            <div class="form-group">
                                <label>Password:</label>
                                <input class="form-control" type="password" name='password' id='password' placeholder='password'  required>
                            </div>
                        </div>
                    </div>
                    <div class='row w-100'>
                            <div class='col-md-12'>
                                <div class="form-group">
                                    <label>Confirm Password:</label>
                                    <input class="form-control" type="password" name='password_confirmation' id='password' placeholder='password'  required>
                                </div>
                            </div>
                        </div>
                    <div class='row w-100' style='float:right;'>
                        <div class="modal-footer" >
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id='submit' class="btn btn-primary" >Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>