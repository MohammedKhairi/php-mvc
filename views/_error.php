

<div class="form-input-content text-center error-page">
    <h1 class="error-text font-weight-bold"><?=$exceptions->getCode()?></h1>
    <h4 class="d-flex justify-content-center align-items-center">
        <i style="font-size:3rem;" class="icon-alert-square text-warning"></i>
        <?=$exceptions->getMessage ()?>
    </h4>
    <div>
        <a class="btn btn-primary" href="/cp/dashboard">Back to Home</a>
    </div>
</div>