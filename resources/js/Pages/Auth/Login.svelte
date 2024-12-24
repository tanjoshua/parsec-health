<script>
    import BreezeButton from "@/Components/Button.svelte";
    import BreezeCheckbox from "@/Components/Checkbox.svelte";
    import BreezeGuestLayout from "@/Layouts/Guest.svelte";
    import BreezeInput from "@/Components/Input.svelte";
    import BreezeLabel from "@/Components/Label.svelte";
    import BreezeValidationErrors from "@/Components/ValidationErrors.svelte";
    import { Link, useForm } from "@inertiajs/svelte";
    let err = {};
    export let errors = {};
    export let canResetPassword;
    export let status;

    const form = useForm({
        login: "",
        password: "",
        remember: false,
    });

    $: {
        err = errors;
    }

    const onSubmit = () => {
        $form.post("/login", {
            onSuccess: () => $form.reset("password"),
        });
    };
</script>

<svelte:head>
    <title>Log in</title>
</svelte:head>

<BreezeGuestLayout>
    <BreezeValidationErrors class="mb-4" errors={err} />

    {#if status}
        <div class="mb-4 font-medium text-sm text-green-600">
            {status}
        </div>
    {/if}

    <form on:submit|preventDefault={onSubmit}>
        <div>
            <BreezeLabel for="login" value="Email or Username" />
            <BreezeInput
                id="login"
                type="text"
                class="mt-1 block w-full"
                bind:value={$form.login}
                required
                autofocus
            />
        </div>

        <div class="mt-4">
            <BreezeLabel for="password" value="Password" />
            <BreezeInput
                id="password"
                type="password"
                class="mt-1 block w-full"
                bind:value={$form.password}
                required
                autocomplete="current-password"
            />
        </div>

        <div class="block mt-4">
            <!-- svelte-ignore a11y-label-has-associated-control -->
            <label class="flex items-center">
                <BreezeCheckbox name="remember" bind:checked={$form.remember} />
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            {#if canResetPassword}
                <Link
                    href="/password/reset"
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                >
                    Forgot your password?
                </Link>
            {/if}

            <BreezeButton
                class={`ml-4 ${$form.processing ? "opacity-25" : ""}`}
                disabled={$form.processing}
            >
                Log in
            </BreezeButton>
        </div>
    </form>
</BreezeGuestLayout>
