import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\FaqController::index
* @see app/Http/Controllers/FaqController.php:14
* @route '/faqs'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/faqs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\FaqController::index
* @see app/Http/Controllers/FaqController.php:14
* @route '/faqs'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\FaqController::index
* @see app/Http/Controllers/FaqController.php:14
* @route '/faqs'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::index
* @see app/Http/Controllers/FaqController.php:14
* @route '/faqs'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\FaqController::index
* @see app/Http/Controllers/FaqController.php:14
* @route '/faqs'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::index
* @see app/Http/Controllers/FaqController.php:14
* @route '/faqs'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::index
* @see app/Http/Controllers/FaqController.php:14
* @route '/faqs'
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
* @see \App\Http\Controllers\FaqController::show
* @see app/Http/Controllers/FaqController.php:45
* @route '/faqs/{faq}'
*/
export const show = (args: { faq: string | number | { id: string | number } } | [faq: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/faqs/{faq}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\FaqController::show
* @see app/Http/Controllers/FaqController.php:45
* @route '/faqs/{faq}'
*/
show.url = (args: { faq: string | number | { id: string | number } } | [faq: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { faq: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { faq: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            faq: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        faq: typeof args.faq === 'object'
        ? args.faq.id
        : args.faq,
    }

    return show.definition.url
            .replace('{faq}', parsedArgs.faq.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\FaqController::show
* @see app/Http/Controllers/FaqController.php:45
* @route '/faqs/{faq}'
*/
show.get = (args: { faq: string | number | { id: string | number } } | [faq: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::show
* @see app/Http/Controllers/FaqController.php:45
* @route '/faqs/{faq}'
*/
show.head = (args: { faq: string | number | { id: string | number } } | [faq: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\FaqController::show
* @see app/Http/Controllers/FaqController.php:45
* @route '/faqs/{faq}'
*/
const showForm = (args: { faq: string | number | { id: string | number } } | [faq: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::show
* @see app/Http/Controllers/FaqController.php:45
* @route '/faqs/{faq}'
*/
showForm.get = (args: { faq: string | number | { id: string | number } } | [faq: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::show
* @see app/Http/Controllers/FaqController.php:45
* @route '/faqs/{faq}'
*/
showForm.head = (args: { faq: string | number | { id: string | number } } | [faq: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

const FaqController = { index, show }

export default FaqController