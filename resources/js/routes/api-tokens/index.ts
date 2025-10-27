import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Settings\ApiTokenController::index
* @see app/Http/Controllers/Settings/ApiTokenController.php:15
* @route '/settings/api-tokens'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/settings/api-tokens',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::index
* @see app/Http/Controllers/Settings/ApiTokenController.php:15
* @route '/settings/api-tokens'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::index
* @see app/Http/Controllers/Settings/ApiTokenController.php:15
* @route '/settings/api-tokens'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::index
* @see app/Http/Controllers/Settings/ApiTokenController.php:15
* @route '/settings/api-tokens'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::index
* @see app/Http/Controllers/Settings/ApiTokenController.php:15
* @route '/settings/api-tokens'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::index
* @see app/Http/Controllers/Settings/ApiTokenController.php:15
* @route '/settings/api-tokens'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::index
* @see app/Http/Controllers/Settings/ApiTokenController.php:15
* @route '/settings/api-tokens'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::store
* @see app/Http/Controllers/Settings/ApiTokenController.php:32
* @route '/settings/api-tokens'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/settings/api-tokens',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::store
* @see app/Http/Controllers/Settings/ApiTokenController.php:32
* @route '/settings/api-tokens'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::store
* @see app/Http/Controllers/Settings/ApiTokenController.php:32
* @route '/settings/api-tokens'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::store
* @see app/Http/Controllers/Settings/ApiTokenController.php:32
* @route '/settings/api-tokens'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::store
* @see app/Http/Controllers/Settings/ApiTokenController.php:32
* @route '/settings/api-tokens'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::destroy
* @see app/Http/Controllers/Settings/ApiTokenController.php:48
* @route '/settings/api-tokens/{token}'
*/
export const destroy = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/settings/api-tokens/{token}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::destroy
* @see app/Http/Controllers/Settings/ApiTokenController.php:48
* @route '/settings/api-tokens/{token}'
*/
destroy.url = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { token: args }
    }

    if (Array.isArray(args)) {
        args = {
            token: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        token: args.token,
    }

    return destroy.definition.url
            .replace('{token}', parsedArgs.token.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::destroy
* @see app/Http/Controllers/Settings/ApiTokenController.php:48
* @route '/settings/api-tokens/{token}'
*/
destroy.delete = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::destroy
* @see app/Http/Controllers/Settings/ApiTokenController.php:48
* @route '/settings/api-tokens/{token}'
*/
const destroyForm = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Settings\ApiTokenController::destroy
* @see app/Http/Controllers/Settings/ApiTokenController.php:48
* @route '/settings/api-tokens/{token}'
*/
destroyForm.delete = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const apiTokens = {
    index: Object.assign(index, index),
    store: Object.assign(store, store),
    destroy: Object.assign(destroy, destroy),
}

export default apiTokens