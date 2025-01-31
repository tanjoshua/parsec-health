<script lang="ts">
	import dayjs from "dayjs";
	import type { Appointment } from "@/types/appointment";
	import { cn } from "@/utils";
	import * as DropdownMenu from "@/components/ui/dropdown-menu/index.js";
	import * as Dialog from "@/components/ui/dialog/index.js";
	import { buttonVariants } from "../ui/button";
	import { ChevronDown, Clock, X } from "lucide-svelte";

	let { appointment }: { appointment: Appointment } = $props();
</script>

<Dialog.Root>
	<Dialog.Trigger>
		<div>
			<button
				class={cn(
					"hover:bg-accent flex flex-col sm:flex-row gap-2 rounded-lg border p-3 text-left w-full",
				)}
			>
				<div class="min-w-[12rem]">
					<div class="font-semibold">
						{dayjs(appointment.start_time).format("ddd, DD MMM")}
					</div>
					<div class="text-sm text-muted-foreground">
						{`${dayjs(appointment.start_time).format("h:mma")} - ${dayjs(appointment.end_time).format("h:mm a")}`}
					</div>
				</div>
				<div class="">
					<div class="flex w-full flex-col gap-1">
						<div class="flex items-start">
							<div>
								<div class="font-semibold">
									{appointment.customer_name}
								</div>
							</div>

							<div class={cn("ml-auto text-xs")}></div>
						</div>
						<div class="text-xs font-medium">Some more info</div>
					</div>
					<div class="text-muted-foreground line-clamp-2 text-xs">
						{appointment.remarks}
					</div>
				</div>
				<div class="ml-auto">
					<DropdownMenu.Root>
						<DropdownMenu.Trigger
							class={buttonVariants({ variant: "outline" })}
						>
							Edit
							<ChevronDown />
						</DropdownMenu.Trigger>
						<DropdownMenu.Content align="end">
							<DropdownMenu.Item>
								<Clock />
								Reschedule Appointment
							</DropdownMenu.Item>
							<DropdownMenu.Item>
								<X />
								Cancel Appointment</DropdownMenu.Item
							>
						</DropdownMenu.Content>
					</DropdownMenu.Root>
				</div>
			</button>
		</div>
	</Dialog.Trigger>
	<Dialog.Content class="sm:max-w-[425px]">
		<Dialog.Header>
			<Dialog.Title
				class="text-xl font-semibold text-gray-900 tracking-tight"
				>{appointment.customer_name}</Dialog.Title
			>
			<Dialog.Description class="text-sm text-muted-foreground ">
				<span
					>{dayjs(appointment.start_time).format("ddd, DD MMM")}</span
				>,
				<span class=""
					>{`${dayjs(appointment.start_time).format("h:mma")} - ${dayjs(appointment.end_time).format("h:mm a")}`}</span
				>
			</Dialog.Description>
		</Dialog.Header>
		<div>
			{#if appointment.remarks}
				{appointment.remarks}
			{:else}
				No remarks.
			{/if}
		</div>
		<Dialog.Footer></Dialog.Footer>
	</Dialog.Content>
</Dialog.Root>
