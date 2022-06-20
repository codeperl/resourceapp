import store from "../stores";
import _ from 'lodash';
import Swal from 'sweetalert2';
import { PDF, HTML, LINK } from './ConstRepository';
const STORAGE_RELATIVE_URL = 'resources/download/';

export default {
    isEmptyObject(obj) {
        return _.isEmpty(obj);
    },

    destroyWithConfirmation(callback, params, text="You won't be able to revert this!") {
        Swal.fire({
            title: 'Are you sure?',
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                callback(params).then(res => {
                    if(res.data.status) {
                        this.successMessage();
                    } else {
                        this.failedMessage();
                    }
                }).catch(err => {
                    this.failedMessage();
                });
            } else if(result.isDenied) {
                this.failedMessage();
            } else if(result.isDismissed) {
                this.dismissedMessage();
            }
        })
    },

    failedMessage() {
        Swal.fire(
            'Failed!',
            'Cannot be deleted!',
            'warning'
        );
    },

    successMessage() {
        Swal.fire(
            'Success!',
            'Deleted successfully!',
            'success'
        );
    },

    dismissedMessage() {
        Swal.fire(
            'Cancelled!',
            'Cancelled delete operation!',
            'info'
        );
    },

    reconfirmMaintenance(callback, params) {
        Swal.fire({
            title: 'Are you sure?',
            text: `You want to keep ${params.command} the maintenance for website?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, keep it ${params.command}!`
        }).then((result) => {
            if (result.isConfirmed) {
                callback(params).then(res => {
                    if(res.data.status) {
                        this.successOperation();
                    } else {
                        this.failedOperation();
                    }
                }).catch(err => {
                    this.failedOperation();
                });
            } else if(result.isDenied) {
                this.failedOperation();
            } else if(result.isDismissed) {
                this.dismissedOperation();
            }
        })
    },

    successOperation() {
        Swal.fire(
            'Success!',
            'Performed successfully!',
            'success'
        );
    },

    failedOperation() {
        Swal.fire(
            'Failed!',
            'Operation failed!',
            'warning'
        );
    },

    dismissedOperation() {
        Swal.fire(
            'Cancelled!',
            'Cancelled the operation!',
            'info'
        );
    },

    validParamId(param) {
        return ((param.id===null) || (param.id===undefined));
    },

    removeItem(arr, val) {
        let idx = arr.indexOf(val);
        if (idx !== -1) {
            arr.splice(idx, 1);
        }

        return arr;
    },

    removeArr(fromArr, toArr) {
        return fromArr.filter(n => !toArr.includes(n));
    },

    matchNames(str) {
        return str.match(/(?<=@)(.*?)(?=:)/ig);  // /[^\@\:]+(?=\:)/ig OR /(?<=@)(.*?)(?=:)/ig
    },

    charactersLeft(limit, length) {
        return (limit - length) + " / " + limit + " characters remaining.";
    },

    resourceTypes() {
        return [
            PDF, HTML, LINK
        ];
    },

    getStorageUrl() {
        return STORAGE_RELATIVE_URL;
    }
}
