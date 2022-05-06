<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <inertialink :href="route('admin.dashboard.index')" class="brand-link">
      <img
        :src="'/storage/m_logo.png'"
        alt="Mad Logo"
        class="brand-image img-circle elevation-3"
        style="opacity: 0.8"
      />
      <span class="brand-text font-weight-light">AdminPOS</span>
    </inertialink>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img
            :src="'/storage/user2-160x160.jpg'"
            class="img-circle elevation-2"
            alt="User Image"
          />
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ $page.props.user.name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
          <li class="nav-item">
            <inertialink
              :href="route('admin.dashboard.index')"
              class="nav-link"
              :class="route().current('admin.dashboard.*') ? 'active' : ' '"
            >
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </inertialink>
          </li>
          <li
            class="nav-item menu-open"
            :class="
              route().current('admin.admins.*') ||
              route().current('admin.users.*') ||
              route().current('admin.permissions.*') ||
              route().current('admin.roles.*')
                ? 'active menu-is-opening menu-open'
                : ' '
            "
          >
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Role & Permissions
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <inertialink
                  :href="route('admin.admins.index')"
                  class="nav-link"
                  :class="route().current('admin.admins.*') ? 'active' : ' '"
                >
                  <i class="far fa-circle nav-icon"></i>
                  <p>Admins</p>
                </inertialink>
              </li>
              <li class="nav-item">
                <inertialink
                  :href="route('admin.users.index')"
                  class="nav-link"
                  :class="route().current('admin.users.*') ? 'active' : ' '"
                >
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users</p>
                </inertialink>
              </li>
              <li class="nav-item">
                <inertialink
                  :href="route('admin.roles.index')"
                  class="nav-link"
                  :class="route().current('admin.roles.*') ? 'active' : ' '"
                >
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roles</p>
                </inertialink>
              </li>
              <li
                class="nav-item"
                v-if="
                  $page.props.auth.hasRole.superAdmin ||
                  $page.props.auth.hasRole.admin
                "
              >
                <inertialink
                  :href="route('admin.permissions.index')"
                  class="nav-link"
                  :class="
                    route().current('admin.permissions.*') ? 'active' : ' '
                  "
                >
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permissions</p>
                </inertialink>
              </li>
            </ul>
          </li>
          <li
            class="nav-item"
            :class="
              route().current('admin.categories.*')
                ? 'active menu-is-opening menu-open'
                : ' '
            "
          >
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Master
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <inertialink
                  :href="route('admin.categories.index')"
                  class="nav-link"
                  :class="
                    route().current('admin.categories.*') ? 'active' : ' '
                  "
                >
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori</p>
                </inertialink>
              </li>
              <li class="nav-item">
                <inertialink
                  :href="route('admin.products.index')"
                  class="nav-link"
                  :class="route().current('admin.products.*') ? 'active' : ' '"
                >
                  <i class="far fa-circle nav-icon"></i>
                  <p>Produk</p>
                </inertialink>
              </li>
            </ul>
          </li>
          <li class="nav-header">MISC</li>
          <li class="nav-item">
            <inertialink :href="route('dashboard')" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Site</p>
            </inertialink>
          </li>
          <li class="nav-item">
            <form @submit.prevent="logout">
              <button class="nav-link" type="submit">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Logout</p>
              </button>
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>
<script>
export default {
  methods: {
    logout() {
      this.$inertia.post(route("logout"));
    },
  },
};
</script>
