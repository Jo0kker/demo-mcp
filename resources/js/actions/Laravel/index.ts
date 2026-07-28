import Fortify from './Fortify'
import Mcp from './Mcp'
import Passport from './Passport'
import Sanctum from './Sanctum'

const Laravel = {
    Fortify: Object.assign(Fortify, Fortify),
    Mcp: Object.assign(Mcp, Mcp),
    Passport: Object.assign(Passport, Passport),
    Sanctum: Object.assign(Sanctum, Sanctum),
}

export default Laravel