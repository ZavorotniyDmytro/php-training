<?php

namespace View;

class BootstrapView extends RecipeListView {
    const ASSETS_FOLDER = 'view/bootstrap-view/';
    private function showUserInfo() {
        ?>
        <div class="container user-info">
            <div class="row">
                <div class="col-md-12 col-md-offset-8 text-center lead">
                    <span>Hello <?php echo $_SESSION['user']; ?>!</span>
                    <?php if($this->checkRight('user', 'admin')):?>
                        <a class="btn btn-primary" href="?action=admin">Administration</a>
                    <?php endif; ?>
                    <a class="btn btn-info" href="?action=logout">Logout</a>
                </div>
            </div>
        </div>
        <?php
    }
    private function showRecipes ($recipes) {
        ?>
        <div class="container recipe-list">
            <div class="row text-center">
                <form name="recipe-form" method="get" class="d-flex align-items-center">
                    <div class="form-group row">
                        <div class="col-xs-12 col-md-6">
                            <label for="recipe">Recipe</label>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <select name="recipe" class="form-control" style="width: 200%;" onchange="document.forms['recipe-form'].submit();">
                                <option value=""></option>
                                <?php
                                foreach ($recipes as $currecipe) { 
                                    echo "<option " . (($currecipe->getId() == $_GET['recipe'])?"selected":"") . " value='" . $currecipe->getId() . "'>" . $currecipe->getPatient() . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>
                <?php if($this->checkRight('recipe', 'create')):?>
                    <div class="col-xs-12 col-md-9 text-md-right">
                        <a href="?action=create-recipe" class="btn btn-success">Add recipe</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    private function showRecipe(\Model\Recipe $recipe) {
        ?>
        <div class="container recipe-info">
            <div class="row text-center flex-column align-items-center">
                <h1 class="col-xs-12 mb-2"><span class="text-primary"><?php echo $recipe->getPatient(); ?></span></h1>
                <p class="col-xs-12 col-md-5 col-md-offset-1 mb-2">Born <span class="text-danger"><?php echo $recipe->getBorn(); ?></span></p>
                <p class="col-xs-12 col-md-5 mb-2">Doctor is <span class="text-success"><?php echo $recipe->getDoctor(); ?></span></p>
                <div class="recipe-control col-xs-12 mb-4">
                    <?php if($this->checkRight('recipe', 'edit')):?>
                        <a class="btn btn-primary mr-2" href="?action=edit-recipe-form&recipe=<?php echo $_GET['recipe']; ?>">Edit data</a>
                    <?php endif; ?>
                    <?php if($this->checkRight('recipe', 'delete')):?>
                        <a class="btn btn-danger" href="?action=delete-recipe&recipe=<?php echo $_GET['recipe']; ?>">Delete data</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
    private function showMedicines ($medicines) {
        ?>
        <section class="container medicines">
            <div class="row text-center">
            <?php if(isset($_GET['recipe']) && $_GET['recipe']): ?>
                        <form name='medicines-filter' method='post' class="d-flex align-items-center">
                            <div class="col-xs-12 col-md-4">
                                <label for="medicine_filter">Filter by medicine</label> 
                            </div>
                            <div class="col-xs-4 col-md-6">
                                <input class="form-control" type="text" id="medicine_filter" name='medicine_filter' value='<?php echo isset($_POST['medicine_filter']) ? $_POST['medicine_filter'] : ''; ?>'>
                            </div>
                            <div class="col-xs-3 col-md-1">
                                <input type="submit" value='Filter' class="btn btn-info">
                            </div>
                        </form>
                    <?php if($this->checkRight('medicine', 'create')):?>
                            <div class="col-xs-12 col-md-7 text-md-right">
                                <a class="btn btn-success" href="?action=create-medicine-form&recipe=<?php echo $_GET['recipe']; ?>" class="add-medicine-button">Add medicine</a>
                            </div>
                    <?php endif; ?>
            </div>
            <div class="row text-center table-medicines">
                <table class="table col-xs-12">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Medicine Name</th>
                            <th>Dosage</th>
                            <th>Form</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($medicines)): ?>
                            <?php foreach($medicines as $key => $medicine): ?>
                                <?php $medicineFilter = isset($_POST['medicine_filter']) ? $_POST['medicine_filter'] : '';
                                    if(empty($medicineFilter) || stristr($medicine->getName(), $medicineFilter)): ?>
                                    <tr class="<?php echo $row_class; ?>">
                                        <td><?php echo ($key + 1); ?></td>
                                        <td><?php echo $medicine->getName(); ?></td>
                                        <td><?php echo $medicine->getDosage(); ?></td>
                                        <td><?php echo $medicine->getForm(); ?></td>
                                        <td>
                                            <?php if($this->checkRight('medicine', 'edit')):?>
                                                <a class="btn btn-primary btn-xs" href="?action=edit-medicine-form&recipe=<?php
                                                    echo $_GET['recipe']; ?>&file=<?php
                                                        echo $medicine->getId();
                                                    ?>">Edit</a>
                                            <?php endif; ?>
                                            |
                                            <?php if($this->checkRight('medicine', 'delete')):?>
                                                <a class="btn btn-danger btn-xs" href="?action=delete-medicine&recipe=<?php
                                                    echo $_GET['recipe']; ?>&file=<?php
                                                        echo $medicine->getId();
                                                    ?>">Delete</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
    public function showMainForm($recipes, \Model\Recipe $recipe, $medicines) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/main.css">
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
            <title>List of medicines</title>
        </head>
        <body>
            <header>
                <?php $this->showUserInfo();?>
                <?php
                    if($this->checkRight('recipe', 'view')) {
                        $this->showRecipes($recipes);
                        if(isset($_GET['recipe']) || $_GET['recipe']) $this->showRecipe($recipe);
                    }
                ?>
            </header>
            <?php if($this->checkRight('medicine', 'view')) $this->showMedicines($medicines); ?>
        </body>
        </html>
        <?php
    }
    public function showRecipeEditForm(\Model\Recipe $recipe) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
            <title>Data editing</title>
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 mx-auto mt-4">
                        <a class="btn btn-info btn-sm" href="index.php?recipe=<?php echo $_GET['recipe']; ?>">Home</a>
                        <form class="mt-3 p-3 border rounded" style="background-color: #f8f9fa;" name="edit-data" method='post' action='?action=edit-recipe&recipe=<?php echo $_GET['recipe'];?>'>
                            <div class="form-group mb-2"><label for="patient">Patient: </label><input class="form-control" type="text" name="patient" value="<?php echo $recipe->getPatient(); ?>"></div>
                            <div class="form-group mb-2"><label for="born">Born: </label><input class="form-control" type="text" name="born" value="<?php echo $recipe->getBorn(); ?>"></div>
                            <div class="form-group mb-2"><label for="doctor">Doctor: </label><input class="form-control" type="text" name="doctor" value="<?php echo $recipe->getDoctor(); ?>"></div>
                            <button type="submit" class="btn btn-success mx-auto d-block" name="ok">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
    public function showMedicineEditForm(\Model\Medicine $medicine) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/checkbox.min.css">
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
            <title>Edit medicine</title>
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 mx-auto mt-4">
                        <a class="btn btn-info btn-sm" href="index.php?recipe=<?php echo $_GET['recipe']; ?>">Home</a>
                        <form class="mt-3 p-3 border rounded" style="background-color: #f8f9fa;" name="edit-medicine" method='post' action='?action=edit-medicine&file=<?php echo $_GET['file'];?>&recipe=<?php echo $_GET['recipe']?>'>
                            <div class="form-group mb-2"><label for="name">Name: </label><input class="form-control" type="text" name="name" value="<?php echo $medicine->getName();?>"></div>
                            <div class="form-group mb-2"><label for="dosage">Dosage: </label><input class="form-control" type="text" name="dosage" value="<?php echo $medicine->getDosage(); ?>"></div>
                            <div class="form-group mb-2"><label for="form">Form: </label><input class="form-control" type="text" name="form" value="<?php echo $medicine->getForm(); ?>"></div>
                            <div class="checkbox"><label><input type="checkbox" name="recovered" <?php echo ("1" == $medicine->getRecovered())?"checked":""; ?> value="1"> Is this patient recovered?</label></div>
                            <button type="submit" class="btn btn-success mx-auto d-block" name="ok">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
    public function showMedicineCreateForm() {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/checkbox.min.css">
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
            <title>Add medicine</title>
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 mx-auto mt-4">
                        <a class="btn btn-info btn-sm" href="?recipe=<?php echo $_GET['recipe']; ?>">Home</a>
                        <form class="mt-3 p-3 border rounded" style="background-color: #f8f9fa;" name="edit-medicine" method='post' action="?action=create-medicine&recipe=<?php echo $_GET['recipe'];?>">
                            <div class="form-group mb-2"><label for="name">Name: </label><input class="form-control" type="text" name="name"></div>
                            <div class="form-group mb-2"><label for="dosage">Dosage: </label><input class="form-control" type="text" name="dosage"></div>
                            <div class="form-group mb-2"><label for="form">Form: </label><input class="form-control" type="text" name="form"></div>
                            <div class="checkbox"><label><input type="checkbox" name="recovered"> Is this patient recovered?</label></div>
                            <button type="submit" class="btn btn-success mx-auto d-block" name="ok">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
    public function showLoginForm() {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/login.min.css">
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
            <title>Authentication</title>
        </head>
        <body>
            <form class="login-container" method="post" action="?action=checkLogin">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-sm-6 col-md-4 col-lg-3 col-sm-offset-3 col-md-offset-4 mx-auto mt-4 mt-3 p-3 border rounded" style="background-color: #f8f9fa;">
                            <h2 class="col-xs-12">Log In</h2>
                            <div class="form-recipe"><p><input class="form-control" type="text" name="username" placeholder="Username"></p></div>
                            <div class="form-recipe"><p><input class="form-control" type="password" name="password" placeholder="Password"></p></div>
                            <button class="btn btn-default" type="submit">Log in</button>
                            <div class="login-link mt-4">
                                <a href="#">Forgot Password?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </body>
        </html>
        <?php
    }
    public function showAdminForm($users) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/checkbox.min.css">
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
            <title>Administration</title>
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 mx-auto mt-8">
                        <header>
                            <a class="btn btn-info btn-sm pull-left btn-sm" href="index.php" class='home-button'>Home</a>
                            <h1 class="col-xs-12 text-center">User administration</h1>
                        </header>
                        <div class="row text-center table-medicines">
                            <section class="container medicines">
                                <div class="mt-3 p-3 border rounded" style="background-color: #f8f9fa;">
                                    <table class="table col-xs-12">
                                        <thead><tr><th>User</th></tr></thead>
                                        <tbody>
                                            <?php foreach($users as $user):?>
                                                <?php if($user->getUserName() != $_SESSION['user'] && $user->getUserName() != 'admin' && trim($user->getUserName()) != '' ): ?>
                                                    <tr class="<?php echo $row_class; ?>"><td><a href="?action=edit-user-form&username=<?php echo $user->getUserName();?>"><?php echo $user->getUserName();?></td></tr>
                                                <?php endif; ?>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
    public function showUserEditForm(\Model\User $user) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="<?php echo self::ASSETS_FOLDER; ?>css/checkbox.min.css">
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/jquery.min.js"></script>
            <script src="<?php echo self::ASSETS_FOLDER; ?>js/bootstrap.min.js"></script>
            <title>Editing users</title>
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 mx-auto mt-4">
                        <a class="btn btn-info btn-sm float-left" href="?action=admin">To the user list</a>
                        <form class="mt-3 p-3 border rounded" style="background-color: #f8f9fa;" name='edit-user' method="post" action='?action=edit-user&user=<?php echo $_GET['username']; ?>'>
                                <div class="form-group">
                                    <label for="user_name">Username: </label>
                                    <input class="form-control" readonly type="text" name='user_name' value='<?php echo $user->getUserName(); ?>'>
                                </div>
                                <div class="form-group">
                                    <label for="user_pwd">Password: </label>
                                    <input class="form-control" type="text" name='user_pwd' value='<?php echo $user->getPassword(); ?>'>
                                </div>
                            <div class="row">
                                <div class="col-6 checkbox-group mt-3">
                                    <p>Recipe:</p>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" <?php echo ("1" == $user->getRight(0))?"checked":""; ?> name='right0' value='1'>
                                    <span>Revision</span></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" <?php echo ("1" == $user->getRight(1))?"checked":""; ?> name='right1' value='1'>
                                    <span>Creation</span></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" <?php echo ("1" == $user->getRight(2))?"checked":""; ?> name='right2' value='1'>
                                    <span>Edition</span></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" <?php echo ("1" == $user->getRight(3))?"checked":""; ?> name='right3' value='1'>
                                    <span>Deletion</span></div>
                                </div>
                                <div class="col-6 checkbox-group mt-3">
                                    <p>Medicine:</p>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" <?php echo ("1" == $user->getRight(4))?"checked":""; ?> name='right4' value='1'>
                                    <span>Revision</span></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" <?php echo ("1" == $user->getRight(5))?"checked":""; ?> name='right5' value='1'>
                                    <span>Creation</span></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" <?php echo ("1" == $user->getRight(6))?"checked":""; ?> name='right6' value='1'>
                                    <span>Edition</span></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" <?php echo ("1" == $user->getRight(7))?"checked":""; ?> name='right7' value='1'>
                                    <span>Deletion</span></div>
                                </div>
                            </div>
                            <div class="checkbox-group mt-3">
                                <p>Users:</p>
                                <div class="form-check"><input class="form-check-input" type="checkbox" <?php echo ("1" == $user->getRight(8))?"checked":""; ?> name='right8' value='1'>
                                <span>Administration</span></div>
                            </div>
                            <button class="btn btn-success float-right" type="submit" name='ok'>Change</button>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}
?>