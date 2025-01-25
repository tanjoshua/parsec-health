<script>
	import BreezeCheckbox from "@/Components/Checkbox.svelte";
	import BreezeGuestLayout from "@/Layouts/Guest.svelte";
	import BreezeValidationErrors from "@/Components/ValidationErrors.svelte";
	import { Link, useForm } from "@inertiajs/svelte";
	import FormInput from "@/components/ui/input/form-input.svelte";
	import { Button } from "@/components/ui/button";
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
		<div clas="mt-1">
			<FormInput
				label="Email or Username"
				id="login"
				bind:value={$form.login}
				required
				autofocus
			/>
		</div>

		<div class="mt-4">
			<FormInput
				label="Password"
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

			<Button
				class={`ml-4 ${$form.processing ? "opacity-25" : ""}`}
				disabled={$form.processing}>Log in</Button
			>
		</div>
	</form>
</BreezeGuestLayout>
