import FaqController from './FaqController'
import Admin from './Admin'
import Settings from './Settings'

const Controllers = {
    FaqController: Object.assign(FaqController, FaqController),
    Admin: Object.assign(Admin, Admin),
    Settings: Object.assign(Settings, Settings),
}

export default Controllers