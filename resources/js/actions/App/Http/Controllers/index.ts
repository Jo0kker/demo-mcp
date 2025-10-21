import FaqController from './FaqController'
import Settings from './Settings'

const Controllers = {
    FaqController: Object.assign(FaqController, FaqController),
    Settings: Object.assign(Settings, Settings),
}

export default Controllers