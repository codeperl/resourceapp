import Public from '../layouts/Public';
import Resource from '../pages/Resource';
import ResourceType from '../pages/ResourceType';

const route = [
    { path: '/', name:'protected', component: Public,
        children: [
            { path: '', name:'resource', component: Resource },
            { path: '/resource-types', name:'resource-type', component: ResourceType }
        ],
    },
];

export default route;
