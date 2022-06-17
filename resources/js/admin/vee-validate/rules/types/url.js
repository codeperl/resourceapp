import { extend } from "vee-validate";

extend('url', {
    validate(value) {
        if (value) {
            return /^(http(s)?:\/\/)[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/.test(value);
        }

        return false;
    },
    message: 'This value must be a valid URL',
})
