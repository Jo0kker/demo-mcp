import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
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
export const show = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
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
show.url = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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
show.get = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::show
* @see app/Http/Controllers/FaqController.php:45
* @route '/faqs/{faq}'
*/
show.head = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\FaqController::show
* @see app/Http/Controllers/FaqController.php:45
* @route '/faqs/{faq}'
*/
const showForm = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::show
* @see app/Http/Controllers/FaqController.php:45
* @route '/faqs/{faq}'
*/
showForm.get = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::show
* @see app/Http/Controllers/FaqController.php:45
* @route '/faqs/{faq}'
*/
showForm.head = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

/**
* @see \App\Http\Controllers\FaqController::create
* @see app/Http/Controllers/FaqController.php:61
* @route '/faqs/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/faqs/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\FaqController::create
* @see app/Http/Controllers/FaqController.php:61
* @route '/faqs/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\FaqController::create
* @see app/Http/Controllers/FaqController.php:61
* @route '/faqs/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::create
* @see app/Http/Controllers/FaqController.php:61
* @route '/faqs/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\FaqController::create
* @see app/Http/Controllers/FaqController.php:61
* @route '/faqs/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::create
* @see app/Http/Controllers/FaqController.php:61
* @route '/faqs/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::create
* @see app/Http/Controllers/FaqController.php:61
* @route '/faqs/create'
*/
createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

/**
* @see \App\Http\Controllers\FaqController::store
* @see app/Http/Controllers/FaqController.php:69
* @route '/faqs'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/faqs',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\FaqController::store
* @see app/Http/Controllers/FaqController.php:69
* @route '/faqs'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\FaqController::store
* @see app/Http/Controllers/FaqController.php:69
* @route '/faqs'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\FaqController::store
* @see app/Http/Controllers/FaqController.php:69
* @route '/faqs'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\FaqController::store
* @see app/Http/Controllers/FaqController.php:69
* @route '/faqs'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

/**
* @see \App\Http\Controllers\FaqController::edit
* @see app/Http/Controllers/FaqController.php:86
* @route '/faqs/{faq}/edit'
*/
export const edit = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/faqs/{faq}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\FaqController::edit
* @see app/Http/Controllers/FaqController.php:86
* @route '/faqs/{faq}/edit'
*/
edit.url = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return edit.definition.url
            .replace('{faq}', parsedArgs.faq.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\FaqController::edit
* @see app/Http/Controllers/FaqController.php:86
* @route '/faqs/{faq}/edit'
*/
edit.get = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::edit
* @see app/Http/Controllers/FaqController.php:86
* @route '/faqs/{faq}/edit'
*/
edit.head = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\FaqController::edit
* @see app/Http/Controllers/FaqController.php:86
* @route '/faqs/{faq}/edit'
*/
const editForm = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::edit
* @see app/Http/Controllers/FaqController.php:86
* @route '/faqs/{faq}/edit'
*/
editForm.get = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FaqController::edit
* @see app/Http/Controllers/FaqController.php:86
* @route '/faqs/{faq}/edit'
*/
editForm.head = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit.form = editForm

/**
* @see \App\Http\Controllers\FaqController::update
* @see app/Http/Controllers/FaqController.php:96
* @route '/faqs/{faq}'
*/
export const update = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/faqs/{faq}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\FaqController::update
* @see app/Http/Controllers/FaqController.php:96
* @route '/faqs/{faq}'
*/
update.url = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{faq}', parsedArgs.faq.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\FaqController::update
* @see app/Http/Controllers/FaqController.php:96
* @route '/faqs/{faq}'
*/
update.put = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\FaqController::update
* @see app/Http/Controllers/FaqController.php:96
* @route '/faqs/{faq}'
*/
const updateForm = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\FaqController::update
* @see app/Http/Controllers/FaqController.php:96
* @route '/faqs/{faq}'
*/
updateForm.put = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

/**
* @see \App\Http\Controllers\FaqController::destroy
* @see app/Http/Controllers/FaqController.php:113
* @route '/faqs/{faq}'
*/
export const destroy = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/faqs/{faq}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\FaqController::destroy
* @see app/Http/Controllers/FaqController.php:113
* @route '/faqs/{faq}'
*/
destroy.url = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return destroy.definition.url
            .replace('{faq}', parsedArgs.faq.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\FaqController::destroy
* @see app/Http/Controllers/FaqController.php:113
* @route '/faqs/{faq}'
*/
destroy.delete = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\FaqController::destroy
* @see app/Http/Controllers/FaqController.php:113
* @route '/faqs/{faq}'
*/
const destroyForm = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\FaqController::destroy
* @see app/Http/Controllers/FaqController.php:113
* @route '/faqs/{faq}'
*/
destroyForm.delete = (args: { faq: number | { id: number } } | [faq: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const faqs = {
    index: Object.assign(index, index),
    show: Object.assign(show, show),
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
}

export default faqs