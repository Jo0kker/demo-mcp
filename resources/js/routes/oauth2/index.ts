import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see routes/ai.php:13
* @route '/oauth2/authorize'
*/
export const authorize = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: authorize.url(options),
    method: 'get',
})

authorize.definition = {
    methods: ["get","head"],
    url: '/oauth2/authorize',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/ai.php:13
* @route '/oauth2/authorize'
*/
authorize.url = (options?: RouteQueryOptions) => {
    return authorize.definition.url + queryParams(options)
}

/**
* @see routes/ai.php:13
* @route '/oauth2/authorize'
*/
authorize.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: authorize.url(options),
    method: 'get',
})

/**
* @see routes/ai.php:13
* @route '/oauth2/authorize'
*/
authorize.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: authorize.url(options),
    method: 'head',
})

/**
* @see routes/ai.php:13
* @route '/oauth2/authorize'
*/
const authorizeForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: authorize.url(options),
    method: 'get',
})

/**
* @see routes/ai.php:13
* @route '/oauth2/authorize'
*/
authorizeForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: authorize.url(options),
    method: 'get',
})

/**
* @see routes/ai.php:13
* @route '/oauth2/authorize'
*/
authorizeForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: authorize.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

authorize.form = authorizeForm

/**
* @see routes/ai.php:20
* @route '/oauth2/token'
*/
export const token = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: token.url(options),
    method: 'post',
})

token.definition = {
    methods: ["post"],
    url: '/oauth2/token',
} satisfies RouteDefinition<["post"]>

/**
* @see routes/ai.php:20
* @route '/oauth2/token'
*/
token.url = (options?: RouteQueryOptions) => {
    return token.definition.url + queryParams(options)
}

/**
* @see routes/ai.php:20
* @route '/oauth2/token'
*/
token.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: token.url(options),
    method: 'post',
})

/**
* @see routes/ai.php:20
* @route '/oauth2/token'
*/
const tokenForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: token.url(options),
    method: 'post',
})

/**
* @see routes/ai.php:20
* @route '/oauth2/token'
*/
tokenForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: token.url(options),
    method: 'post',
})

token.form = tokenForm

const oauth2 = {
    authorize: Object.assign(authorize, authorize),
    token: Object.assign(token, token),
}

export default oauth2