<header class="sticky-top">
	<!-- navbar desktop -->
	<nav class="navbar navbar-expand-lg bg-uc-blue-1 sticky-top">
		<div class="container-fluid mx-0">
			<a class="navbar-brand" href="/">
				<img src="https://kit-digital-uc-prod.s3.amazonaws.com/assets/uc_sm.svg" alt=" Logo UC"
					class="img-fluid" style="height: 30px;">
			</a>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item text-white" style="padding-left:40px; font-size: 2em !important;">
						Mesa de Servicios Tecnológicos SDTI
					</li>
				</ul>
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0 px-4 navbar-nav">
					<li class="nav-item">
						<a class="nav-link navbar-nav-user-img bg-uc-blue-3" style="padding-left:8px;"
							data-bs-toggle="offcanvas" href="#offcanvasUser" role="button"
							aria-controls="offcanvasUser">
							<span class="text-white">{{ Session::all()['navbar_name'] }} <i class="uc-icon text-white"
									style="padding-left:5px;padding-top:6px">arrow_drop_down</i></span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- end navbar desktop -->





	<!-- navbar mobile -->
	<nav class="navbar d-lg-none d-xl-none d-xxl-none bg-white">
		<div class="container-fluid mx-0">
			<div style="justify-content: start;">
				<div class="navbar-brand">
					<a class="nav-link d-inline-block" data-bs-toggle="offcanvas" href="#offcanvasMenuMobile"
						role="button" aria-controls="offcanvasMenuMobile">
						<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#0176de"><path d="M0 0h24v24H0z" fill="none"/><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
					</a>
					<a class="color-uc-blue-1 d-inline-block" style="text-decoration:none" href="/">
						<span style="font-size:1.3rem">Mesa de Servicios SDTI</span>
					</a>
				</div>
			</div>
			<div class="d-flex justify-content-end me-4">
				<ul class="navbar-nav" style="flex-direction:row">
					<li class="nav-item" style="height: 38px;">
						<a class="navbar-user nav-link navbar-nav-user-img bg-uc-blue-3" style="padding-left:8px;"
							data-bs-toggle="offcanvas" href="#offcanvasUser" role="button"
							aria-controls="offcanvasUser">
							<span class="text-white">{{ Session::all()['navbar_name'] }} <i class="uc-icon"
									style="padding-left:5px;padding-top:6px">arrow_drop_down</i></span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- end navbar mobile -->


	<!-- drawer user -->
	<div class="offcanvas offcanvas-end" id="offcanvasUser" aria-labelledby="offcanvasUserLabel">
		<div class="offcanvas-header justify-content-end pb-0 pt-4">
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body pt-0">
			<nav class="accordion" id="sidenavAccordion">
				<div>
					<div>
						<div class="text-center d-block mb-3">
							<div class="mb-3">
								<div class="side-drawer-circle">
									{{ Session::all()['navbar_name'] }}
								</div>
							</div>
							<a href="/user-account" class="text-black">
								<h5>{{ Session::all()['name'] }}</h5>
							</a>
						</div>
						<ul class="uc-navbar-side">
							<li>
								<a href="/user-account">
									Perfil de Usuario
									<i class="uc-icon icon-small">keyboard_arrow_right</i>
								</a>
							</li>
							<li>
								<a href="{{route('logout')}}">
									Cerrar Sesión
									<i class="uc-icon icon-small">keyboard_arrow_right</i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
	</div>
	<!-- end drawer user -->



	<!-- drawer menu mobile -->
	<div class="offcanvas offcanvas-start" id="offcanvasMenuMobile" aria-labelledby="offcanvasMenuMobileLabel">
		<div class="offcanvas-header pb-0">
			<h2 class="offcanvas-title" id="offcanvasAcademicUnitLabel">Menu</h2>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body menu-principal">
			@include('layout.menu')
		</div>
	</div>
	<!-- wnd drawer menu mobile -->
</header>