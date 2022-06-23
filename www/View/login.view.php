
<h1>Page de login</h1>

<!--<h2><?= $firstname;?>, veuillez vous reconnecter</h2>-->

<?php $this->includePartial("form", $user->getLoginForm()) ?>