<template>
    <admin-layout>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-3 justify-content-between">
                        <h1 class="m-0 text-dar">Manajemen Produk</h1>
                    </div>
                    <div class="col-sm-3 text-left">
                        <button type="button" style="letter-spacing: 0.1em;" @click="openModal" class="btn btn-info text">
                            Tambah
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <inertialink :href="route('admin.dashboard.index')">Home</inertialink>
                            </li>
                            <li class="breadcrumb-item active">Produk</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <!-- Table Product -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Stok</th>
                                            <th>Harga</th>
                                            <th>Kategori</th>
                                            <th>Last Update</th>
                                            <th class="text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-if="products.length > 1">
                                            <tr v-for="product in products" :key="product.id">
                                                <td>{{ product.name }}</td>
                                                <td>{{ product.stock }}</td>
                                                <td>{{ product.price }}</td>
                                                <td>
                                                    <template v-for="category in product.category_id" :key="category.id">
                                                            {{ category.name }}
                                                    </template>
                                                </td>
                                                <td class="text-right">
                                                    <button
                                                    type="button"
                                                    class="btn btn-success text-uppercase"
                                                    style="letter-spacing: 0.1em"
                                                    @click="editForm(product)"
                                                    >
                                                    Edit
                                                    </button>
                                                    <button
                                                    type="button"
                                                    class="btn btn-danger text-uppercase ml-1"
                                                    style="letter-spacing: 0.1em"
                                                    @click="deleteProduct(product)"
                                                    >
                                                    Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                            <tr v-else>
                                                <td colspan="6" class="text-center">
                                                    Belum Ada Data
                                                </td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End Table -->
                </div>
            </div>
        </section>
        <div class="modal fade" id="modal-product">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">Edit Admin {{ formTitle }}</h4>
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
                    <div class="card card-primary">
                            <!-- Form Input -->
                        <form @submit.prevent="checkMode" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nama Produk</label>
                                <input type="text" name="name" id="name" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.name}" autocomplete="off" required="required">
                            </div>
                            <div class="invalid-feedback mb-3" :class="{ 'd-block': form.errors.name }">
                                {{ form.errors.name }}
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea name="description" id="description" v-model="form.description" cols="5" rows="6" class="form-control" :class="{ 'is-invalid': form.errors.description}"></textarea>
                            </div>
                            <div class="invalid-feedback" :class="{ 'd-block': form.errors.description }">
                                {{ form.errors.description }}
                            </div>
                            <div class="form-group">
                                <label for="stock">Stok</label>
                                <input type="text" name="stock" id="stock" class="form-control" v-model="form.stock" :class="{ 'is-invalid': form.errors.stock}" autocomplete="off" required="required">
                            </div>
                            <div class="invalid-feedback mb-3" :class="{ 'd-block': form.errors.stock }">
                                {{ form.errors.stock }}
                            </div>
                            <div class="form-group">
                                <label for="price">Harga</label>
                                <input type="text" name="price" id="price" class="form-control" v-model="form.price" :class="{ 'is-invalid': form.errors.price}" autocomplete="off" required="required">
                            </div>
                            <div class="invalid-feedback mb-3" :class="{ 'd-block': form.errors.price }">
                                {{ form.errors.price }}
                            </div>
                            <div class="form-group">
                                <label for="photo">Foto</label>
                                <input type="file" name="photo" accept="image/*" id="photo" class="form-control" v-on:change="onFileChange" :class="{ 'is-invalid': form.errors.photo}" autocomplete="off" required="required">
                            </div>
                            <div class="invalid-feedback mb-3" :class="{ 'd-block': form.errors.photo }">
                                {{ form.errors.photo }}
                            </div>

                            <div class="form-group">
                                <label for="Categories" class="h4">Categories</label>
                                <multiselect v-model="form.categories" :options="categoryOptions" :multiple="false"
                                    :taggable="true"
                                    placeholder="Choose New Categories"
                                    @tag="addTag"
                                    label="name"
                                    track-by="id"
                                >
                                </multiselect>
                            </div>
                            <div
                            class="invalid-feedback"
                            :class="{ 'd-block': form.errors.categories }"
                            >
                            {{ form.errors.categories }}
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
                            <!-- End Form -->

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
    props: ["products", "categories"],
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
                code: "",
                name: "",
                description: "",
                stock: "",
                price: "",
                photo: "",
                categories: [],
            }),
            categoryOptions: this.categories,
        };
    },
    computed: {
        checkMode() {
            return this.editMode === false ? this.createProduct : this.editProduct;
        },
        buttonText() {
            return this.editedIndex === -1 ? "Save" : "Update";
        }
    },
    methods: {
        onFileChange(e){
                console.log(e.target.files[0]);
                this.file = e.target.files[0];
        },
        addTag(newCategory) {
            let tag = {
                name: newCategory,
            };
            this.categoryOptions.push(tag);
            this.form.categories.push(tag);
        },
        openModal() {
            this.form.clearErrors()
            this.editMode = false;
            this.form.reset();
            this.editedIndex = -1;
            $("#modal-product").modal("show");
        },
        closeModal() {
            this.form.clearErrors()
            this.editMode = false;
            this.form.reset();
            $("#modal-product").modal("hide");
        },
        createProduct(){
            this.form.post(this.route("admin.products.store"), {
                onSuccess: () => {
                    this.form.reset();
                    Toast.fire({
                        icon: "success",
                        title: "New Product",
                    });
                },
            });
        },
        // editForm(category) {
        //     this.editMode = true;
        //     this.editedIndex = this.products.indexOf(category);
        //     this.form.name = category.name;
        //     this.form.description = category.description;
        //     this.form.id = category.id;
        // },
        // editCategory() {
        //     this.form.patch(
        //     this.route("admin.products.update", this.form.id, this.form),
        //     {
        //         preserveScroll: true,
        //         onSuccess: () => {
        //         Toast.fire({
        //             icon: "info",
        //             title: this.form.name.toUpperCase() + " Updated!",
        //         });
        //         this.form.reset();
        //         },
        //     }
        //     );
        // },
        // deleteCategory(category) {
        //     Swal.fire({
        //         title: "Are you sure?",
        //         text: "You won't be able to revert this!",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Yes, delete it!",
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //         this.form.delete(this.route("admin.products.destroy", category), {
        //             preserveScroll: true,
        //             onSuccess: () => {
        //             this.form.reset();
        //             Swal.fire({
        //                 title: "Deleted!",
        //                 text: "Category deleted.",
        //                 icon: "success",
        //                 timer: 1500,
        //                 showConfirmButton: false,
        //             });
        //             },
        //         });
        //         }
        //     });
        // },
    }
}
</script>
