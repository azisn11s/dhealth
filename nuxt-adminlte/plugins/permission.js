export default ({app, store}, inject)=> {
    inject('permission', (role, ability)=> {
        var availableRoles = store.state.auth.user.roles;
        var result = false;

        availableRoles.forEach(associatedRole => {
            associatedRole.features.forEach(feature => {
                // console.log('LOOP THROGH APPLIED FEATURE', feature.slug);
                if (feature.slug === role) {
                    // let arrayAbilities = Object.keys(feature.pivot.abilities).map((key) => [key, feature.pivot.abilities[key]]);
                    // console.log('TAH IEU NU DIBUTUHKAN..', [feature.slug, feature.pivot.abilities[ability]]);
                    result = feature.pivot.abilities[ability];
                }
            })
        });

        // console.log('AVAILABLE ROLES', availableRoles);
        // console.log('AVAILABLE PERMISSIONS', permissions);
        // console.log('ASK FOR ROLE', role); 

        if (result == undefined) {
            return false;
        }

        return result;
    });
}