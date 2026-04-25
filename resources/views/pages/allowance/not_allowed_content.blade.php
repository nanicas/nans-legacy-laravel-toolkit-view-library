<div class="error-page">
    <h2>Oops!</h2>
    <h1 class="error-code"> 405 </h1>
    <h2>Not Found</h2>
    <div class="error-details">
        Nos desculpe, um erro ocorreu. Essa requisição não é permitida pelo tipo de seu usuário!
    </div>

    <div class="error-actions">
        <a href="{{ route(Helper::cleanRoute(\App\Providers\RouteServiceProvider::HOME)) }}" class="btn btn-primary btn-lg">
            <span class="glyphicon glyphicon-home"></span>
            Voltar para à página inicial
        </a>
        <a href="#" class="btn btn-default btn-lg">
            <span class="glyphicon glyphicon-envelope"></span> Contato
        </a>
    </div>
</div>