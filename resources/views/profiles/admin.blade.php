<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    body {
        margin-top: 20px;
    }

    .avatar {
        width: 200px;
        height: 200px;
    }
    </style>
</head>

<body>
    <div class="container bootstrap snippets bootdey">
        <h1 class="text-primary">Edit Profile</h1>
        <hr>
        <div class="row">
            <!-- left column -->
            <div class="col-md-3">
                <div class="text-center">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png"
                        class="avatar img-circle img-thumbnail" alt="avatar">
                    <h6>Upload a different photo...</h6>

                    <input type="file" class="form-control">
                </div>
            </div>

            <!-- edit form column -->
            <div class="col-md-9 personal-info">
                <div class="alert alert-info alert-dismissable">
                    <a class="panel-close close" data-dismiss="alert">×</a>
                    <i class="fa fa-coffee"></i>
                    This is an <strong>.alert</strong>. Use this to show important messages to the user.
                </div>
                <h3>Personal info</h3>
                <form action="{{ route('profile.update') }}" method="POST" class="form-horizontal">
                    @csrf

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="col-lg-3 control-label">First name:</label>
                        <div class="col-lg-8">
                            <input class="form-control" name="first_name" type="text"
                                value="{{ old('first_name', $user->first_name) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Last name:</label>
                        <div class="col-lg-8">
                            <input class="form-control" name="last_name" type="text"
                                value="{{ old('last_name', $user->last_name) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Old Password:</label>
                        <div class="col-lg-8">
                            <input class="form-control" name="oldpassword" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">New Password:</label>
                        <div class="col-lg-8">
                            <input class="form-control" name="newpassword" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Confirm New Password:</label>
                        <div class="col-lg-8">
                            <input class="form-control" name="newpassword_confirmation" type="password">
                        </div>
                    </div>
                    <div class="clearfix">
                        <button class="btn btn-primary pull-right">Save Changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <hr>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>