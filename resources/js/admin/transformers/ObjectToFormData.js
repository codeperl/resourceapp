export const objectToFormData = function(obj, form, namespace) {
    let fd = form || new FormData();
    let formKey;

    for(let property in obj) {
        if(obj.hasOwnProperty(property)) {
            if(namespace) {
                formKey = namespace + '[' + property + ']';
            } else {
                formKey = property;
            }

            if (obj[property] instanceof Date) {
                fd.append(formKey, obj[property].toISOString());
            } else if (Array.isArray(obj[property])) {
                obj[property].forEach((element, index) => {
                    const tempFormKey = `${formKey}[${index}]`;
                    objectToFormData(element, fd, tempFormKey);
                });
            } else if(typeof obj[property] === 'object' && !(obj[property] instanceof File)) {
                objectToFormData(obj[property], fd, property);
            } else {
                // if it's a string or a File object
                fd.append(formKey, obj[property]);
            }
        }
    }

    return fd;
};
