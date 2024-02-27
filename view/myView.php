<?php

namespace View;

class MyView extends RecipeListView {
    private function showRecipes ($recipes) {
        ?>
        <form name='recipe-form' method='get' class="recipe-form-container">
                <label for="recipe">Recipe</label>
                <select name="recipe">
                    <option value=""></option>
                    <?php
                        foreach ($recipes as $currecipe) {
                            echo "<option " . (($currecipe->getId() == $_GET['recipe'])?"selected":"") . " value='" . 
                            $currecipe->getId() . "'>" . $currecipe->getPatient() . "</option>";
                        }
                    ?>
                </select>
                <input type="submit" value="OK">
                <?php if($this->checkRight('recipe', 'create')):?>
                    <a href="forms/create-recipe.php" class="add-recipe-button">Add recipe</a>
                <?php endif; ?>
            </form>
        <?php
    }
    private function showRecipe(\Model\Recipe $recipe) {
        ?>
        <div class="header-content">
            <div class="recipe-name">Recipe for <?php echo $recipe->getPatient(); ?></div>
            <div class="recipe-info">Born - <span class="recipe-info-highlight"><?php echo $recipe->getBorn(); ?></span></div>
            <div class="recipe-info">Doctor is <span class="recipe-info-highlight"><?php echo $recipe->getDoctor(); ?></span></div>
        </div>
        <div class='action'>
            <?php if($this->checkRight('recipe', 'edit')):?>
                <a href="forms/edit-data.php?recipe=<?php echo $_GET['recipe']; ?>">Edit data</a>
            <?php endif; ?>
            <?php if($this->checkRight('recipe', 'delete')):?>
                <a href="forms/delete-data.php?recipe=<?php echo $_GET['recipe']; ?>">Delete data</a>
            <?php endif; ?>
        </div>
        <?php
    }
    private function showMedicines ($medicines) {
        ?>
        <section class="medicines-list container">
            <?php if(isset($_GET['recipe']) && $_GET['recipe']): ?>
                <div class="filter-and-button-container">
                    <form name='medicines-filter' method='post'>
                        <label for="medicine_filter">Filter by medicines</label>    
                        <input type="text" id="medicine_filter" name='medicine_filter' value='<?php echo isset($_POST['medicine_filter']) ? $_POST['medicine_filter'] : ''; ?>'>
                        <input type="submit" value='Filter'>
                    </form>
                    <?php if($this->checkRight('medicine', 'create')):?>
                        <a href="forms/create-medicine.php?recipe=<?php echo $_GET['recipe']; ?>" class="add-medicine-button">Add medicine</a>
                    <?php endif; ?>
                </div>
                <table class="medicines-table">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Name</th>
                            <th>Dosage</th>
                            <th>Medicine's form</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($medicines)): ?>
                            <?php foreach($medicines as $key => $medicine): ?>
                                <?php $medicine_filter = isset($_POST['medicine_filter']) ? $_POST['medicine_filter'] : '';
                                    if(empty($medicine_filter) || stristr($medicine->getName(), $medicine_filter)): ?>
                                    <tr>
                                        <td><?php echo ($key + 1); ?></td>
                                        <td><?php echo $medicine->getName(); ?></td>
                                        <td><?php echo $medicine->getDosage(); ?></td>
                                        <td><?php echo $medicine->getForm(); ?></td>
                                        <td>
                                            <?php if($this->checkRight('medicine', 'edit')):?>
                                                <a href="forms/edit-medicine.php?recipe=<?php
                                                    echo $_GET['recipe']; ?>&file=<?php
                                                        echo $medicine->getId();
                                                    ?>">Edit</a>
                                            <?php endif; ?>
                                            |
                                            <?php if($this->checkRight('medicine', 'delete')):?>
                                                <a href="forms/delete-medicine.php?recipe=<?php
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
        </section>
        <?php
    }
    public function showMainForm($recipes, \Model\Recipe $recipe, $medicines) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style.css">
            <title>List of medicines</title>
        </head>
        <body>
            <header class="header">
                <div>
                    <span>Hello <?php echo $_SESSION['user']; ?>!</span>
                    <?php if($this->checkRight('user', 'admin')): ?>
                        <a href="admin/index.php">Administration</a>
                    <?php endif; ?>
                    <a href="/lr10/auth/logout.php">Log out</a>
                </div>
                <?php if($this->checkRight('recipe', 'view')){
                    $this->showRecipes($recipes);
                    if(isset($_GET['recipe']) || $_GET['recipe']) {
                        $this->showRecipe($recipe);
                    } 
                }
                ?>
            </header>
            <?php
            if($this->checkRight('medicine', 'view')) {
                $this->showMedicines($medicines);
            }
            ?>
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
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/edit-data-form-style.css">
            <title>Data editing</title>
        </head>
        <body>
            <a href="../index.php?recipe=<?php echo $_GET['recipe'];?>">Home</a>
            <form class="container" name="edit-data" method='post'>
                <div><label for="patient">Recipe for </label><input type="text" name="patient" value="<?php echo $recipe->getPatient(); ?>"></div>
                <div><label for="born">Born: </label><input type="text" name="born" value="<?php echo $recipe->getBorn(); ?>"></div>
                <div><label for="doctor">Doctor: </label><input type="text" name="doctor" value="<?php echo $recipe->getDoctor(); ?>"></div>
                <div><input type="submit" name="ok" value="Save"></div>
            </form>
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
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel='stylesheet' type='text/css' href='../css/edit-medicine-form-style.css'>
            <title>Edit medicine</title>
        </head>
        <body>
            <a href="../index.php?recipe=<?php echo $_GET['recipe'];?>">Home</a>
            <form class="container" name="edit-medicine" method='post'>
                <div><label for="name">Name: </label><input type="text" name="name" value="<?php echo $medicine->getName();?>"></div>
                <div><label for="dosage">Medicine's dosage: </label><input type="text" name="dosage" value="<?php echo $medicine->getDosage(); ?>"></div>
                <div><label for="form">Medicine's form: </label><input type="text" name="form" value="<?php echo $medicine->getForm(); ?>"></div>
                <div><input type="checkbox" name="recovered" <?php echo ("1" == $medicine->getRecovered())?"checked":""; ?> value="1"> Has this patient recovered?</div>
                <div><input type="submit" name="ok" value="Save"></div>
            </form>
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
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel='stylesheet' type='text/css' href='../css/edit-medicine-form-style.css'>
            <title>Add medicine</title>
        </head>
        <body>
            <a href="../index.php?recipe=<?php echo $_GET['recipe'];?>">Home</a>
            <form class="container" name="edit-medicine" method='post'>
                <div><label for="name">Name: </label><input type="text" name="name"></div>
                <div><label for="dosage">Medicine's dosage: </label><input type="text" name="dosage"></div>
                <div><label for="form">Medicine's form: </label><input type="text" name="form"></div>
                <div><input type="checkbox" name="recovered"> Has this patient recovered?</div>
                <div><input type="submit" name="ok" value="Save"></div>
            </form>
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
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="../css/login-style.css">
            <title>Authentication</title>
            <body>
            <form class="login-container" method="post">
                <h2>Log In</h2>
                <p><input class="login-input" type="text" name="username" placeholder="Username"></p>
                <p><input class="login-input" type="password" name="password" placeholder="Password"></p>
                <p><input class="login-button" type="submit" value="Log in"></p>
                <div class="login-link">
                    <a href="#">Forgot Password?</a>
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
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel='stylesheet' type='text/css' href='../css/admin-style.css'>
            <title>Administration</title>
        </head>
        <body>
            <header>
                <a href="../index.php" class='home-button'>Home</a>
                <h1>User administration</h1>
            </header>
            <section>
                <table>
                    <thead><tr><th>User</th></tr></thead>
                    <tbody>
                        <?php foreach($users as $user):?>
                            <?php if($user->getUserName() != $_SESSION['user'] && $user->getUserName() != 'admin' && trim($user->getUserName()) != '' ): ?>
                                <tr><td><a href="edit-user.php?username=<?php echo $user->getUserName();?>"><?php echo $user->getUserName();?></a></td></tr>
                            <?php endif; ?>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </section>
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
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel='stylesheet' text='text/css' href='../css/admin-edit-style.css'>
            <title>Editing users</title>
        </head>
        <body>
            <a href="index.php">To the user list</a>
            <form name='edit-user' method="post">
                <div>
                    <div>
                        <label for="user_name">Username: </label>
                        <input readonly type="text" name='user_name' value='<?php echo $user->getUserName(); ?>'>
                    </div>
                    <div>
                        <label for="user_pwd">Password: </label>
                        <input type="text" name='user_pwd' value='<?php echo $user->getPassword(); ?>'>
                    </div>
                </div>
                <div>
                    <p>Recipe:</p>
                    <input type="checkbox" <?php echo ("1" == $user->getRight(0))?"checked":""; ?> name='right0' value='1'>
                    <span>Revision</span>
                    <input type="checkbox" <?php echo ("1" == $user->getRight(1))?"checked":""; ?> name='right1' value='1'>
                    <span>Creation</span>
                    <input type="checkbox" <?php echo ("1" == $user->getRight(2))?"checked":""; ?> name='right2' value='1'>
                    <span>Edition</span>
                    <input type="checkbox" <?php echo ("1" == $user->getRight(3))?"checked":""; ?> name='right3' value='1'>
                    <span>Deletion</span>
                </div>
                <div>
                    <p>Medicine:</p>
                    <input type="checkbox" <?php echo ("1" == $user->getRight(4))?"checked":""; ?> name='right4' value='1'>
                    <span>Revision</span>
                    <input type="checkbox" <?php echo ("1" == $user->getRight(5))?"checked":""; ?> name='right5' value='1'>
                    <span>Creation</span>
                    <input type="checkbox" <?php echo ("1" == $user->getRight(6))?"checked":""; ?> name='right6' value='1'>
                    <span>Edition</span>
                    <input type="checkbox" <?php echo ("1" == $user->getRight(7))?"checked":""; ?> name='right7' value='1'>
                    <span>Deletion</span>
                </div>
                <div>
                    <p>Users:</p>
                    <input type="checkbox" <?php echo ("1" == $user->getRight(8))?"checked":""; ?> name='right8' value='1'>
                    <span>Administration</span>
                </div>
                <div><input type="submit" name='ok' value='Change'></div>
            </form>
        </body>
        </html>
        <?php
    }
}
?>