<template>
<div>
    <div class="table-responsive">
        <vuetable ref="vuetable" api-url="/api/products" table-class="table table-bordered table-striped table-hover" ascending-icon="fa fa-chevron-up" descending-icon="fa fa-chevron-down" pagination-path="payload" data-path="payload.data" :per-page="perPage"
            :fields="columns" :pagination-component="paginationComponent" @vuetable:pagination-data="onPaginationData"></vuetable>
            <div class="vuetable-pagination well">
                <vuetable-pagination-info class="vuetable-pagination-info" ref="paginationInfo" :paginationInfoClass="paginationInfoClass" :pagination-info-template="paginationInfoTemplate"></vuetable-pagination-info>
                <vuetable-pagination class="vuetable-pagination-component" :icons="VueTablePagination.css.icons" :css="VueTablePagination.css" ref="pagination" @vuetable-pagination:change-page="onChangePage"></vuetable-pagination>
            </div>
    </div>
</div>
</template>
<script>
import Vue from 'vue';
Vue.component('custom-product-actions', {
    template: [
        '<div class="pull-right">',
        '<button class="btn btn-xs btn-default btn-link" @click="itemAction(\'edit-item\', rowData)"><i class="fa fa-pencil"></i> Edit</button>',
        '<button class="btn btn-xs btn-default btn-link" @click="itemAction(\'delete-item\', rowData)"><i class="fa fa-trash icon"></i> Delete</button>',
        '</div>'
    ].join(''),
    props: {
        rowData: {
            type: Object,
            required: true
        }
    },
    methods: {
        itemAction: function(action, data) {
            var VueTableComponent = this.$parent;
            var ListingComponent = VueTableComponent.$parent;
            var ProductView = ListingComponent.$parent;

            if (action == 'edit-item') {
                ProductView.withId = data.id;
                ProductView.ViewState = "product";
            } else if (action == 'delete-item') {
                ListingComponent.showConfirmProductDelete(data.id);
            }
        }
    }
});
export default {
    data: function() {
        return {
            columns: [{
                    name: 'name',
                    label: 'Product',
                }, {
                    name: 'price',
                    label: 'Price',
                }, {
                    name: 'category.name',
                    label: 'category',
                },
                '__component:custom-product-actions',
            ],
            pageData: {},
            perPage: 10,
            paginationInfoTemplate: 'Showing products <b>{from}</b> to <b>{to}</b> out of a total of <b>{total}</b> products',
            paginationInfoClass: 'pull-left pagination-info',
            VueTablePagination: {
                css: {
                    wrapperClass: 'pull-right',
                    pageClass: 'btn btn-default',
                    linkClass: '',
                    disabledClass: 'btn-disabled',
                    activeClass: 'btn btn-primary',
                    paginationClass: 'ui bottom attached segment grid',
                    paginationInfoClass: 'left floated left aligned six wide column',
                    icons: {
                        first: 'btn btn-default fa fa-backward',
                        prev: 'btn btn-default fa fa-chevron-left',
                        next: 'btn btn-default fa fa-chevron-right',
                        last: 'btn btn-default fa fa-forward',
                    }
                }
            }
        }
    },
    methods: {
        onPaginationData: function(data) {
            this.pageData = data;
            this.$refs.paginationInfo.setPaginationData(data);
            this.$refs.pagination.setPaginationData(data);
        },
        onChangePage: function(newPageNumber) {
            this.$refs.vuetable.changePage(newPageNumber);
        },
        showConfirmProductDelete: function(productId) {
            var that = this;
            swal({
                title: "Are you sure you want to delete this product?",
                text: "This action cannot be undone!",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "I'm sure, delete it!",
                closeOnConfirm: true
            }, function() {
                that.$http.delete('/api/products/' + productId).then((response) => {
                    if (response.data.success) {
                        that.$refs.vuetable.reload();
                    }
                });
            });
        }
    }
}
</script>
<style>
.vuetable-pagination .pagination-info {
    padding-top: 7px;
}

.vuetable-pagination.well {
    padding: 15px;
    padding-bottom: 50px;
    margin: 0;
}

.vuetable-pagination .btn {
    margin: 0;
}
</style>
