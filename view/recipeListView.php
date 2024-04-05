<?php

namespace View;

abstract class RecipeListView {
    const SIMPLEVIEW = 0;
    const BOOTSTRAPVIEW = 1;
    private $user;

    public function setCurrentUser(\Model\User $user) {
        $this->user = $user;
    }
    public function checkRight($object, $right) {
        return $this->user->checkRight($object, $right);
    }

    public abstract function showMainForm($recipes, \Model\Recipe $recipe, $medicines);
    public abstract function showRecipeEditForm(\Model\Recipe $recipe);
    public abstract function showMedicineEditForm(\Model\Medicine $medicine);
    public abstract function showMedicineCreateForm();
    public abstract function showLoginForm();
    public abstract function showAdminForm($users);
    public abstract function showUserEditForm(\Model\User $user);

    public static function makeView($type) {
        if ($type == self::SIMPLEVIEW) {
            return new MyView();
        } elseif ($type == self::BOOTSTRAPVIEW) {
            return new BootstrapView();
        }
        return new MyView();
    }
}
?>