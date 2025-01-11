<script lang="ts">
	import TenantLayout from "@/Layouts/TenantLayout.svelte";
	import PaginationBar from "@/components/table/pagination-bar.svelte";
	import { Badge } from "@/components/ui/badge";
	import * as Breadcrumb from "@/components/ui/breadcrumb";
	import * as Table from "@/components/ui/table";
	import type { PaginatedResult } from "@/types/pagination";
	import type { Tenant } from "@/types/tenant";
	import type { Visit } from "@/types/visit";
	import dayjs from "dayjs";
	import relativeTime from "dayjs/plugin/relativeTime";
	import { router } from "@inertiajs/svelte";

	dayjs.extend(relativeTime);

	let {
		tenant,
		visits,
		pageSize,
	}: {
		tenant: Tenant;
		visits: PaginatedResult<Visit>;
		pageSize: number;
	} = $props();
</script>

<svelte:head>
	<title>Visits | Parsec Health</title>
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
					<Breadcrumb.Page>Visits</Breadcrumb.Page>
				</Breadcrumb.Item>
			</Breadcrumb.List>
		</Breadcrumb.Root>
	{/snippet}
	<div>
		<div class="container mx-auto p-4 space-y-8">
			<div>
				<h2 class="text-2xl font-bold">Visits</h2>
			</div>
			<div>
				<Table.Root
					><Table.Header>
						<Table.Row>
							<Table.Head class="w-[100px]">Status</Table.Head>
							<Table.Head>Patient Visit</Table.Head>
							<Table.Head class="text-right">Visited</Table.Head>
						</Table.Row>
					</Table.Header>

					<Table.Body>
						{#each visits.data as visit}
							<Table.Row>
								<Table.Cell>
									{#if visit.left_at}
										<Badge variant="secondary"
											>Completed</Badge
										>
									{:else}
										<Badge>Active</Badge>
									{/if}
								</Table.Cell>
								<Table.Cell>
									<div class="font-medium">
										{visit.patient.name}
									</div>
									<div class="text-xs text-muted-foreground">
										Visited {dayjs(
											visit.registered_at,
										).from(dayjs())}
									</div>
								</Table.Cell>
								<Table.Cell class="text-right">
									{dayjs(visit.registered_at).from(dayjs())}
								</Table.Cell>
							</Table.Row>
						{/each}
					</Table.Body></Table.Root
				>
				<div class="mt-4">
					<PaginationBar
						pagination={visits}
						pageSize={pageSize.toString()}
						onPageSizeChange={(newPageSize) => {
							router.get(
								route("tenants.visits.index", {
									tenant: tenant.id,
									pageSize: newPageSize,
								}),
							);
						}}
					/>
				</div>
			</div>
		</div>
	</div></TenantLayout
>
