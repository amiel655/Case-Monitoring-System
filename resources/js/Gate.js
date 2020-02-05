export default class Gate {

    constructor(user) {
        this.user = user;
    }

    isStaff() {
        return this.user.type === 'Staff';
    }

    isAdmin() {
        return this.user.type === 'Admin';
    }

    isSuperAdmin() {
        return this.user.type === 'Super Admin';
    }

    isStaffAndSuperAdmin() {
        return this.user.type === 'Staff' || this.user.type === 'Super Admin';
    }

    isAdminAndSuperAdmin() {
        return this.user.type === 'Admin' || this.user.type === 'Super Admin';
    }
}
