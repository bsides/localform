<div class="container">
  <div class="jumbotron text-center">
    <h1>Confirme sua cidade</h1>
    <p class="lead">
      Por favor, preencha com o nome da sua cidade no campo abaixo
    </p>
    <!-- <p><a class="btn btn-lg btn-success" ng-href="#">Ok!</a></p> -->
  </div>

  <div class="row">
    <div class="col-md-offset-3 col-md-6">
    <div class="panel-body">

      <form class="form-horizontal">
        <div class="form-group form-group-lg">
          <label for="inputCidade" class="col-sm-2 control-label">Cidade</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="inputCidade" placeholder="">
            <span class="help-block">O nome da cidade que você está agora</span>
          </div>
        </div>
        <div class="form-group">
          <label for="inputCEP" class="col-sm-2 control-label">CEP</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="inputCEP" placeholder="">
            <span class="help-block">Confirme com seu CEP. Se não souber ou não quiser informar, não precisa preencher</span>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-primary">Manda ver!</button>
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>

<!--   <div class="row">
    <div class="col-sm-6 col-md-4" ng-repeat="awesomeThing in awesomeThings | orderBy:'rank'">
      <div class="thumbnail">
        <img class="pull-right" ng-src="images/{{awesomeThing.logo}}" alt="{{awesomeThing.title}}">
        <div class="caption">
          <h3>{{awesomeThing.title}}</h3>
          <p>{{awesomeThing.description}}</p>
          <p><a ng-href="{{awesomeThing.url}}">{{awesomeThing.url}}</a></p>
        </div>
      </div>
    </div>
  </div> -->
</div>
