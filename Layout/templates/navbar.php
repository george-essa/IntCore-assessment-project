
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
  <div class="container">
      <a class="navbar-brand" href="index.php">Intcore</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
              <div class="dropdown">
                  <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <?php echo $_SESSION['username']; ?>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <a class="dropdown-item font-weight-bolder" href="logout.php">Log out</a>
                  </div>
              </div>
          </ul>
      </div>
  </div>
</nav>






















