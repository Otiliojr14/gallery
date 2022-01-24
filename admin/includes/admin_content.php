<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Admin
                <small>Subheading</small>
            </h1>

            <?php
            
            // $user = new User();

            // $user->user_name = "ana86";
            // $user->user_password = "orh";
            // $user->first_name = "Ana";
            // $user->last_name = "Let";

            // var_dump($user->save());

            $user = User::find_user_by_id(12);

            $user->user_name = 'alan2003';

            $user->last_name = 'Flojo';

            var_dump($user->save());

            // $user = User::find_user_by_id(3);

            // var_dump($user->delete());

            // $user = User::find_user_by_id(3);
            // $user->first_name = "Yazkin";
            // $user->user_name = "yazkin73";

            // $user->save();

            // $user = User::find_user_by_id(4);

            // $user->delete();
            
            ?>

            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i> <a href="index.html">Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-file"></i> Blank Page
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

</div>