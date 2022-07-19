<div>
    <div class="card">
        <div>
            <h1>Votre Email</h1>
        </div>
        <?php if (count($errors)>0) { ?>
            <div class="error">
            <?php foreach ($errors as $key => $error) {
                echo '('.$key.') '.$error.'<br>';
            } ?>
            </div>
        <?php } ?>
        <?php if (count($success)>0) { ?>
            <div class="success">
            <?php foreach ($success as $key => $succ) {
                echo '('.$key.') '.$succ.'<br>';
            } ?>
            </div>
        <?php } ?>
        <?php if($user!==false){
            $this->includePartial("form", $user->getFgtPwdForm());
        } ?>
    </div>
</div>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200;400&display=swap');
    
    .error{
        color: red;
    }

    .success{
        color: green;
    }

    .card {
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 8px;
        width: 30%;
        margin-left: auto;
        margin-right: auto;
        padding: 1.25rem;
        position: absolute;
        top: 35%;
        left: 35%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }

    .card h1 {
        margin: 0 0 1rem 0;
        font-size: 40px;
        letter-spacing: 6px;
    }

    .card input {
        background-color: transparent;
        border: none;
        border-bottom: 1px solid #ffffffb3;
        width: 70%;
        height: 2rem;
        font-size: 18px;
        font-weight: 200;
        color: white;
        margin-top: 1rem;
    }

    .card input::placeholder {
        color: #ffffffb3;
        font-weight: 200;
    }

    .card input:hover {
        border-bottom: 1px solid white;
    }

    .card input:last-child {
        border: 1px solid #ffffffb3;
        color: #ffffffb3;
        cursor: pointer;
        height: 3rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .card input:last-child:hover {
        border: 1px solid white;
        color: #ffffff;
    }

</style>