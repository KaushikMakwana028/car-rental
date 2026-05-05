<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$vehicle_count = !empty($vehicles) ? count($vehicles) : 0;
$featured_vehicle = $vehicle_count ? $vehicles[0] : null;
?>

<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-label">Available Cars</span>
        <span class="stat-value"><?php echo $vehicle_count; ?></span>
        <span class="stat-note">Fresh fleet options ready for city rides, airport drops, and outstation travel.</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Booking Flow</span>
        <span class="stat-value">3</span>
        <span class="stat-note">Choose a car, submit your trip details, and wait for fast booking confirmation.</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Customer Access</span>
        <span class="stat-value">24/7</span>
        <span class="stat-note">Open the customer side anytime to track requests and keep documents updated.</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Design Focus</span>
        <span class="stat-value">1</span>
        <span class="stat-note">One consistent premium interface across Home, Cars, Bookings, Documents, and Profile.</span>
    </div>
</div>

<div class="split-grid">
    <section class="section-card">
        <div class="eyebrow">Book Better</div>
        <div class="card-head">
            <div>
                <h3>Clean journey from browsing to booking.</h3>
                <p>Customers can explore the fleet first, continue into the booking flow when ready, and manage every next step without jumping between mismatched screens.</p>
            </div>
        </div>
        <div class="info-grid">
            <div class="feature-card">
                <strong>Explore first</strong>
                <span>Guests can review the customer area before signing in, so the booking path feels open and modern.</span>
            </div>
            <div class="feature-card">
                <strong>Quick vehicle pick</strong>
                <span>Select a car from the fleet and continue directly to the booking form with the vehicle preselected.</span>
            </div>
            <div class="feature-card">
                <strong>Everything connected</strong>
                <span>Bookings, documents, and profile details all sit inside one mobile-friendly experience.</span>
            </div>
        </div>
        <div class="hero-actions">
            <a class="btn" href="<?php echo base_url('customer/bookings/create'); ?>">Book a Vehicle</a>
            <a class="btn-secondary" href="<?php echo base_url('customer/vehicles'); ?>">Browse Cars</a>
        </div>
    </section>

    <aside class="section-card accent-card">
        <div class="eyebrow">Featured Ride</div>
        <?php if (!empty($featured_vehicle)): ?>
            <?php $featured_image = isset($featured_vehicle['image']) ? trim($featured_vehicle['image']) : ''; ?>
            <div class="vehicle-media<?php echo $featured_image !== '' ? '' : ' vehicle-media-empty'; ?>" style="margin-bottom:18px;border-radius:24px;background:rgba(255,255,255,.08);">
                <?php if ($featured_image !== ''): ?>
                    <img src="<?php echo app_vehicle_image_url($featured_image); ?>" alt="<?php echo html_escape($featured_vehicle['name']); ?>">
                <?php else: ?>
                    <div class="vehicle-empty-badge"><?php echo html_escape(strtoupper(substr($featured_vehicle['name'], 0, 1))); ?></div>
                    <div class="vehicle-empty-copy" style="color:rgba(247,243,231,.72);">Vehicle photo not uploaded yet. Add one from admin for a better customer preview.</div>
                <?php endif; ?>
            </div>
            <div class="card-head" style="margin-bottom:14px;">
                <div>
                    <h3 style="color:#fff;"><?php echo html_escape($featured_vehicle['name']); ?></h3>
                    <p style="color:rgba(247,243,231,.72);"><?php echo html_escape($featured_vehicle['registration_no']); ?> with comfort-focused travel and premium presentation.</p>
                </div>
            </div>
                <div class="metric-strip">
                    <div class="metric-tile">
                        <strong><?php echo (int) $featured_vehicle['seats']; ?></strong>
                    <span>Seats</span>
                </div>
                <div class="metric-tile">
                    <strong><?php echo html_escape($featured_vehicle['fuel_type']); ?></strong>
                    <span>Fuel Type</span>
                </div>
                    <div class="metric-tile">
                        <strong><?php echo html_escape($featured_vehicle['vehicle_type']); ?></strong>
                        <span>Category</span>
                    </div>
                    <div class="metric-tile">
                        <strong>&#8377;<?php echo number_format((float) $featured_vehicle['advance_amount'], 0); ?></strong>
                        <span>Advance</span>
                    </div>
                </div>
        <?php else: ?>
            <div class="empty-state" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.14);color:rgba(247,243,231,.74);">
                No featured vehicle is available right now. Please check the fleet page again shortly.
            </div>
        <?php endif; ?>
    </aside>
</div>

<section class="section-card">
    <div class="card-head">
        <div>
            <div class="eyebrow">Our Fleet</div>
            <h3>Cars customers notice first.</h3>
            <p>Each card is built for quick comparison, with strong visuals and clear pricing details that work well on desktop and mobile.</p>
        </div>
        <a class="btn-secondary" href="<?php echo base_url('customer/vehicles'); ?>">View Full Fleet</a>
    </div>

    <?php if (!empty($vehicles)): ?>
        <div class="vehicle-grid">
            <?php foreach (array_slice($vehicles, 0, 6) as $vehicle): ?>
                <article class="vehicle-card">
                    <?php $vehicle_image = isset($vehicle['image']) ? trim($vehicle['image']) : ''; ?>
                    <div class="vehicle-media<?php echo $vehicle_image !== '' ? '' : ' vehicle-media-empty'; ?>">
                        <?php if ($vehicle_image !== ''): ?>
                            <img src="<?php echo app_vehicle_image_url($vehicle_image); ?>" alt="<?php echo html_escape($vehicle['name']); ?>">
                        <?php else: ?>
                            <div class="vehicle-empty-badge"><?php echo html_escape(strtoupper(substr($vehicle['name'], 0, 1))); ?></div>
                            <div class="vehicle-empty-copy">Photo coming soon for this vehicle.</div>
                        <?php endif; ?>
                    </div>
                    <div class="vehicle-body">
                        <h3><?php echo html_escape($vehicle['name']); ?></h3>
                        <div class="vehicle-meta"><?php echo html_escape($vehicle['registration_no']); ?></div>
                        <div class="spec-list">
                            <div class="spec-row"><span>Type</span><strong><?php echo html_escape($vehicle['vehicle_type']); ?></strong></div>
                            <div class="spec-row"><span>Fuel</span><strong><?php echo html_escape($vehicle['fuel_type']); ?></strong></div>
                            <div class="spec-row"><span>Seats</span><strong><?php echo (int) $vehicle['seats']; ?></strong></div>
                            <div class="spec-row"><span>Rate / KM</span><strong>&#8377;<?php echo number_format((float) $vehicle['rate_per_day'], 2); ?></strong></div>
                            <div class="spec-row"><span>Advance</span><strong>&#8377;<?php echo number_format((float) $vehicle['advance_amount'], 2); ?></strong></div>
                        </div>
                        <a class="btn" href="<?php echo base_url('customer/bookings/create?vehicle_id=' . (int) $vehicle['id']); ?>">Book This Car</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">No vehicles are available right now. Please check back later or contact the admin team for availability.</div>
    <?php endif; ?>
</section>

<div class="split-grid">
    <section class="section-card accent-card">
        <div class="eyebrow">How It Works</div>
        <div class="card-head">
            <div>
                <h3 style="color:#fff;">Booking now feels guided.</h3>
                <p style="color:rgba(247,243,231,.72);">The customer side has a simple flow with strong calls to action, clear review points, and no extra clutter.</p>
            </div>
        </div>
        <div class="info-grid" style="grid-template-columns:1fr;">
            <div class="feature-card" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.10);">
                <strong style="color:#fff;">1. Browse the fleet</strong>
                <span style="color:rgba(247,243,231,.70);">Compare car type, fuel type, seats, and pricing before choosing your ride.</span>
            </div>
            <div class="feature-card" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.10);">
                <strong style="color:#fff;">2. Submit trip details</strong>
                <span style="color:rgba(247,243,231,.70);">Pickup, drop, distance, and dates are captured in a more polished booking form.</span>
            </div>
            <div class="feature-card" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.10);">
                <strong style="color:#fff;">3. Track everything</strong>
                <span style="color:rgba(247,243,231,.70);">View booking progress, manage documents, and update your profile from one place.</span>
            </div>
        </div>
    </section>

    <section class="section-card">
        <div class="eyebrow">Why Choose Us</div>
        <div class="card-head">
            <div>
                <h3>Designed for trust and speed.</h3>
                <p>The customer experience now highlights clarity, modern spacing, and action-focused sections across every page.</p>
            </div>
        </div>
        <div class="info-grid" style="grid-template-columns:1fr;">
            <div class="feature-card">
                <strong>Unified layout</strong>
                <span>Header, cards, spacing, tables, and forms all follow one premium visual system.</span>
            </div>
            <div class="feature-card">
                <strong>Mobile ready</strong>
                <span>Navigation, forms, and vehicle cards collapse cleanly for smaller devices without breaking the design.</span>
            </div>
            <div class="feature-card">
                <strong>Logo-led branding</strong>
                <span>The old CBF text mark is replaced with the actual logo in both the header and footer.</span>
            </div>
        </div>
    </section>
</div>
