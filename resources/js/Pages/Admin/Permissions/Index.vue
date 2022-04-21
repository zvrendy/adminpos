<template>
    <admin-layout>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Permission</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-info text-uppercase" style="letter-spacing: 0.1em;" @click="openModal">
                                        Add
                                    </button>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-capitalize">Permission</th>
                                            <th class="text-capitalize">Description</th>
                                            <th class="text-capitalize">Created</th>
                                            <th class="text-capitalize text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(permission, index) in permissions.data" :key="index">
                                            <td>{{ permission.name }}</td>
                                            <td>{{ permission.description }}</td>
                                            <td>{{ permission.created_at }}</td>
                                            <td class="text-right">
                                                <button type="button" style="letter-spacing: 0.1em;" class="btn btn-success text-uppercase" @click="editModal(permission)">
                                                    Edit
                                                </button>
                                                <button type="button" style="letter-spacing: 0.1em;" class="btn btn-danger text-uppercase m-1" @click="deletePermission(permission)">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                <pagination :links="permissions.links"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="modal-permission">
            <div class="modal-dialog modal-lg modal-dialog-cente">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ formTitle }}</h4>
                        <button type="button" @click="closeModal" aria-label="Close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body overflow-hidden">
                        <p class="h6 text-warning">
                            **"create: ", "read: ", "update: ", "delete:"
                        </p>
                        <div class="d-flex flex-column h4">
                            <span>Preview name: <span>{{ form.name }}</span></span>
                            <span class="mt-3">Preview description: <span>{{ form.description }}</span></span>
                        </div>
                        <div class="card card-primary">
                            <form @submit.prevent="checkMode">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name" class="h4">Permission Name</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="name"
                                            placeholder="Permission Name"
                                            v-model="form.name"
                                            :class="{ 'is-invalid': form.errors.name }"
                                            autofocus="autofocus"
                                            autocomplete="off"
                                        />
                                    </div>
                                    <div class="invalid-feedback mb-3" :class="{ 'd-block': form.errors.name }">
                                        {{ form.errors.name }}
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="h4">Permission Description</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="description"
                                            placeholder="Permission description"
                                            v-model="form.description"
                                            :class="{ 'is-invalid': form.errors.description }"
                                            autofocus="autofocus"
                                            autocomplete="off"
                                        />
                                    </div>
                                    <div class="invalid-feedback mb-3" :class="{ 'd-block': form.errors.description }">
                                        {{ form.errors.description }}
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
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Pagination.vue';
export default {
    props: ['permissions'],
    components: {
        AdminLayout,
        Pagination,
    },
    data(){
        return {
            editedIndex: -1,
            editMode: false,
            form: this.$inertia.form({
                id: "",
                name: "",
                description: "",
            }),
        }
    },
    computed: {
        formTitle(){
            return this.editedIndex === -1 ? "Created New Permission" : "Edit " + this.form.name.toUpperCase() + " Permission";
        },
        buttonText(){
            return this.editedIndex === -1 ? "Save" : "Update";
        },
        checkMode() {
            return this.editMode === false ? this.createPermission : this.editPermission;
        }
    },
    methods: {
        openModal(){
            this.form.clearErrors()
            this.editMode = false;
            this.form.reset();
            this.editedIndex = -1;
            $('#modal-permission').modal("show");
        },
        editModal(permission) {
            this.editMode = true;
            $('#modal-permission').modal('show');
            this.editedIndex = this.permissions.data.indexOf(permission);
            this.form.name = permission.name;
            this.form.description = permission.description;
            this.form.id = permission.id;
        },
        closeModal() {
            this.form.clearErrors()
            this.editMode = false;
            this.form.reset();
            $('#modal-permission').modal('hide');
        },
        createPermission() {
            this.form.post(this.route('admin.permissions.store'), {
                preseveScroll: true,
                onSuccess: () => {
                    this.form.reset();
                    this.closeModal();
                    Toast.fire({
                        icon: 'success',
                        title: 'New Permission Inserted!'
                    });
                },
            });
        },
        editPermission() {
            this.form.patch(
                this.route("admin.permissions.update", this.form.id, this.form),
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
        deletePermission(permission) {
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
                this.form.delete(this.route("admin.permissions.destroy", permission), {
                    preserveScroll: true,
                    onSuccess: () => {
                    this.form.reset();
                    this.closeModal();
                    Swal.fire({
                        title: "Deleted!",
                        text: "Permission deleted.",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false,
                    });
                    },
                });
                }
            });
        },
    }
}
</script>
