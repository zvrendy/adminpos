<template>
  <admin-layout>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Roles & Permission</h3>
                <div class="card-tools">
                  <button
                    type="button"
                    class="btn btn-info text-uppercase"
                    style="letter-spacing: 0.1em;"
                    @click="openModal"
                  >
                    Add
                  </button>
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th class="text-capitalize">Role Name</th>
                      <th class="text-capitalize">Permissions</th>
                      <th class="text-capitalize">Created</th>
                      <th class="text-capitalize text-right">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(role, index) in roles.data" :key="index">
                      <td>{{ role.name }}</td>
                      <td>
                        <div class="d-flex flex-column">
                          <span
                            :key="index"
                            v-for="(permission, index) in role.permissions"
                          >
                            {{ permission.name }}
                          </span>
                        </div>
                      </td>
                      <td>{{ role.created_at }}</td>
                      <td class="text-right">
                        <button
                          type="button"
                          class="btn btn-success text-uppercase"
                          style="letter-spacing: 0.1em"
                          @click="editModal(role)"
                        >
                          Edit
                        </button>
                        <button
                          type="button"
                          class="btn btn-danger text-uppercase ml-1"
                          style="letter-spacing: 0.1em"
                          @click="deleteRole(role)"
                        >
                          Delete
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer clearfix">
                  <pagination :links="roles.links"></pagination>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="modal fade" id="modal-role">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{ formTitle }}</h4>
            <button
              type="button"
              class="close"
              @click="closeModal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body overflow-hidden">
            <div class="h4">
              <span
                >Preview: <span class="text-capitalize">{{ form.name }}</span>
              </span>
            </div>
            <div class="card card-primary">
              <form @submit.prevent="checkMode">
                <div class="card-body">
                  <div class="form-group">
                    <label for="role" class="h4">Role Name</label>
                    <input
                      type="text"
                      class="form-control"
                      id="role"
                      placeholder="Role Name"
                      v-model="form.name"
                      :class="{ 'is-invalid': form.errors.name }"
                      autofocus="autofocus"
                      autocomplete="off"
                    />
                  </div>
                  <div
                    class="invalid-feedback mb-3"
                    :class="{ 'd-block': form.errors.name }"
                  >
                    {{ form.errors.name }}
                  </div>

                  <div class="form-group">
                    <label for="permissions" class="h4">Permissions</label>
                    <multiselect
                      v-model="form.permissions"
                      :options="permissionOptions"
                      :multiple="true"
                      :taggable="true"
                      placeholder="Choose Permission(s)"
                      @addPermissions="addPermissions"
                      label="name"
                      track-by="id"
                    >
                    </multiselect>
                  </div>
                  <div
                    class="invalid-feedback"
                    :class="{ 'd-block': form.errors.permissions }"
                  >
                    {{ form.errors.permissions }}
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button
                    type="button"
                    class="btn btn-danger text-uppercase"
                    style="letter-spacing: 0.1em"
                    @click="closeModal"
                  >
                    Cancel
                  </button>
                  <button
                    type="submit"
                    class="btn btn-info text-uppercase"
                    style="letter-spacing: 0.1em"
                    :disabled="!form.name || form.processing"
                  >
                    {{ buttonText }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </admin-layout>
</template>
<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Pagination.vue";
export default {
  props: ["roles", "permissions"],
  components: {
    AdminLayout,
    Pagination,
  },
  data() {
    return {
      editedIndex: -1,
      editMode: false,
      form: this.$inertia.form({
        id: "",
        name: "",
        permissions: [],
      }),
      permissionOptions: this.permissions,
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Create New Role" : "Edit " + this.form.name.toUpperCase() + " Role";
    },
    buttonText() {
      return this.editedIndex === -1 ? "Save" : "Update";
    },
    checkMode() {
      return this.editMode === false ? this.createRole : this.editRole;
    },
  },
  methods: {
    addPermissions(newPermission) {
      let permission = {
        name: newPermission,
      };
      this.permissionOptions.push(permission);
      this.form.permissions.push(permission);
    },
    openModal() {
    this.form.clearErrors()
      this.editMode = false;
      this.form.reset();
      this.editedIndex = -1;
      $("#modal-role").modal("show");
    },
    editModal(role) {
      this.editMode = true;
      $("#modal-role").modal("show");
      this.editedIndex = this.roles.data.indexOf(role);
      this.form.name = role.name;
      this.form.id = role.id;
      this.form.permissions = role.permissions;
    },
    closeModal() {
        this.form.clearErrors()
      this.editMode = false;
      this.form.reset();
      $("#modal-role").modal("hide");
    },
    createRole() {
      this.form.post(this.route("admin.roles.store"), {
        preserveScroll: true,
        onSuccess: () => {
          this.form.reset();
          this.closeModal();
          Toast.fire({
            icon: "success",
            title: "New Role Inserted!",
          });
        },
      });
    },
    editRole() {
      this.form.patch(
        this.route("admin.roles.update", this.form.id, this.form),
        {
          preserveScroll: true,
          onSuccess: () => {
            Toast.fire({
                icon: "info",
                title: this.form.name.toUpperCase() + " Updated!",
            });
            this.form.reset();
            this.closeModal();
          },
        }
      );
    },
    deleteRole(role) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.form.delete(this.route("admin.roles.destroy", role), {
            preserveScroll: true,
            onSuccess: () => {
              this.form.reset();
              this.closeModal();
              Swal.fire({
                title: "Deleted!",
                text: "Role deleted.",
                icon: "success",
                timer: 1500,
                showConfirmButton: false,
              });
            },
          });
        }
      });
    },
  },
};
</script>
