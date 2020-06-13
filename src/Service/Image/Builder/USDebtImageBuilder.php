<?php
/**
 * This file is part of the US Debt application.
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace App\Service\Image\Builder;

use App\Exception\Image\Builder\WrongSequenceOfConstructionStepsException;
use App\Service\Accounting\USDebtAmountProvider;
use App\ValueObject\File;
use App\ValueObject\Image;
use App\Service\Image\Builder\Interfaces\DebtImageBuilderInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class USDebtImageBuilder
 */
class USDebtImageBuilder implements DebtImageBuilderInterface
{
    private USDebtAmountProvider $debtProvider;

    private Filesystem $fs;

    private string $backgroundPathname;

    private string $fontPathname;

    private string $fontColor;

    private ?\Imagick $backgroundLayer = null;

    private ?\Imagick $debtAmountLayer = null;

    /**
     * USDebtImageBuilder constructor.
     *
     * @param USDebtAmountProvider $USDebtAmountProvider
     * @param Filesystem           $filesystem
     * @param string               $backgroundPathname
     * @param string               $fontPathname
     * @param string               $fontColor
     */
    public function __construct(USDebtAmountProvider $USDebtAmountProvider, Filesystem $filesystem, string $backgroundPathname, string $fontPathname, string $fontColor)
    {
        $this->debtProvider = $USDebtAmountProvider;
        $this->backgroundPathname = $backgroundPathname;
        $this->fontPathname = $fontPathname;
        $this->fontColor = $fontColor;
        $this->fs = $filesystem;
    }

    /**
     * @inheritDoc
     */
    public function buildBackgroundLayer(): DebtImageBuilderInterface
    {
        $this->backgroundLayer = new \Imagick($this->backgroundPathname);

        return $this;
    }

    public function buildDebtAmountLayer(): DebtImageBuilderInterface
    {
        $this->debtAmountLayer = new \Imagick();

        $this->debtAmountLayer->newImage(2844, 248, new \ImagickPixel('transparent'));
        $this->debtAmountLayer->setFormat('png');

        $draw = new \ImagickDraw();
        $draw->setFont((new File($this->fontPathname))->getPathname());
        $draw->setFontSize(255);
        $draw->setTextKerning(7);
        $draw->setTextAlignment(\Imagick::ALIGN_CENTER);
        $draw->setFillColor(new \ImagickPixel($this->fontColor));

        $w = $this->debtAmountLayer->getImageWidth();
        $h = $this->debtAmountLayer->getImageHeight();

        $formatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        $formatter->setPattern('¤   ##,###');
        $amount = $formatter->formatCurrency($this->debtProvider->provide()->toBanknotes(), 'USD');

        $this->debtAmountLayer->annotateImage($draw, $w / 2, 202, 0, $amount);

        $this->debtAmountLayer->distortImage(\Imagick::DISTORTION_PERSPECTIVE, [
            0, 0, 0 + 48, 0,
            0, $h, 0, $h,
            $w, 0, $w - 48, 0,
            $w, $h, $w, $h,
        ], true);

        $this->debtAmountLayer->blurImage(3, 10);

        return $this;
    }

    /**
     * @return Image
     *
     * @throws WrongSequenceOfConstructionStepsException
     */
    public function getImage(): Image
    {
        if (!$this->backgroundLayer instanceof \Imagick) {
            throw new WrongSequenceOfConstructionStepsException('you must first build the background');
        }

        if (!$this->debtAmountLayer instanceof \Imagick) {
            throw new WrongSequenceOfConstructionStepsException('You must first build the amount of debt');
        }

        $this->backgroundLayer->compositeImage(
            $this->debtAmountLayer,
            \Imagick::COMPOSITE_DEFAULT,
            610,
            1015,
            \Imagick::CHANNEL_ALPHA
        );
        $filepath = $this->fs->tempnam('/tmp', 'us_debt_image_');
        $this->backgroundLayer->writeImage($filepath);

        return new Image($filepath);
    }
}
