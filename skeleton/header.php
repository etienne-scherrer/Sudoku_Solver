<body>
	<nav>
		<ul class="nav navbar-nav">
			<li class=<?php echo $content === 'home' ? 'active' : 'inactive' ?>><a href="./?page=home">Home</a></li>
			<li class=<?php echo $content === 'sudoku' ? 'active' : 'inactive' ?>><a href="./?page=sudoku">Sudoku</a></li>
			<li id='user-selected'>
                <?php if (isset($_SESSION['user'])) {
					echo $_SESSION['user']['username'];
				} else {
					echo '<a href="./?page=login">Login</a>';
				}
				?>
		</li>
		</ul>
	</nav>