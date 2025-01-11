<script lang="ts">
	import TenantLayout from "@/Layouts/TenantLayout.svelte";
	import * as Breadcrumb from "@/components/ui/breadcrumb";
	import type { Tenant } from "@/types/tenant";

	let { tenant }: { tenant: Tenant } = $props();
</script>

<svelte:head>
	<title>Appointments | Parsec Health</title>
</svelte:head>

<TenantLayout>
	{#snippet breadcrumbs()}
		<Breadcrumb.Root>
			<Breadcrumb.List>
				<Breadcrumb.Item class="hidden md:block">
					<Breadcrumb.Link href={route("tenants.dashboard", tenant)}
						>{tenant.name}</Breadcrumb.Link
					>
				</Breadcrumb.Item>
				<Breadcrumb.Separator class="hidden md:block" />
				<Breadcrumb.Item>
					<Breadcrumb.Page>Appointments</Breadcrumb.Page>
				</Breadcrumb.Item>
			</Breadcrumb.List>
		</Breadcrumb.Root>
	{/snippet}
	<div class="container mx-auto p-4 space-y-8">
		<div>
			<h2 class="text-2xl font-bold">Appointments</h2>
		</div>
	</div>
</TenantLayout>
