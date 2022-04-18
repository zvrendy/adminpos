<template>
  <div class="dark-mode">
    <div class="wrapper">
      <!-- Preloader -->
      <!-- <div
            class="preloader flex-column justify-content-center align-items-center"
        >
            <img
            class="animation__wobble"
            src="dist/img/AdminLTELogo.png"
            alt="AdminLTELogo"
            height="60"
            width="60"
            />
        </div> -->

      <!-- Navbar -->
      <Navbar />
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <Sidebar />

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <slot name="header"></slot>
              </div>
              <!-- /.col -->

              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <slot></slot>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        control sidebar
      </aside>
      <!-- /.control-sidebar -->

      <!-- Main Footer -->
      <Footer />
    </div>
  </div>
</template>

<script>
import Footer from "@/Components/Footer.vue";
import Navbar from "@/Components/Navbar.vue";
import Sidebar from "@/Components/Sidebar.vue";
export default {
  components: {
    Sidebar,
    Navbar,
    Footer,
  },
};
</script>
